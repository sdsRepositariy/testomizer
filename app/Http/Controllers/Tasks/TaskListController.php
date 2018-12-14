<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users\User as User;
use App\Services\HandleSorting as HandleSorting;
use App\Models\Tasks\TaskFolder as TaskFolder;

class TaskListController extends Controller
{

    /**
     * The folders collection.
     *
     * @var Illuminate\Database\Eloquent\Collection
     */
    protected $folders;

    /**
     * The defaults for sorting.
     *
     * @var array
     */
    protected $sortDefault = [
        'sort' => 'name',
        'order' => 'asc',
    ];

    /**
     * The attributes that can be sorted.
     *
     * @var array
     */
    protected $sortable = ['name'];

    /**
     * The key string for session storage.
     *
     * @var string
     */
    protected $sessionKey = "task_list";

    /**
     * The sort handler helper.
     *
     * @var HandleSorting
     */
    protected $handleSorting;

    /**
     * Create a new controller instance.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(HandleSorting $handleSorting)
    {
        $this->handleSorting = $handleSorting;

        $this->handleSorting->setParameters($this->sortDefault, $this->sortable, $this->sessionKey);
    }

    /**
     * Display the resource.
     *
     * @param  Request  $request
     * @param  string   $taskFolder
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request, $folderId = null)
    {
        if (\Gate::denies('view', 'tasks')) {
            abort(403);
        }

        if (empty($folderId)) {
            $folder = new TaskFolder;
        } else {
            $folder = \Auth::user()->taskFolders()->findOrFail($folderId);
        }

        //Get list data
        $listData = $this->getListData($request, $folder);

        if ($request->ajax()) {
            return view('admin.tasks.list_modal_content', [
                'folders' => $listData['folders'],
                'items' => $listData['items'],
                'folder' => $folder,
                'folderPrimaryAction' => 'list',
                'itemPath' => 'tasks/task',
                'folderPath' => 'tasks/folder',
            ]);
        } else {
            return view('admin.tasks.list', [
                'folders' => $listData['folders'],
                'items' => $listData['items'],
                'sortData' => $listData['sortData'],
                'folder' => $folder,
                'actionMenu' => 'admin.tasks.task_action_menu',
                'itemPath' => 'tasks/task',
                'folderPath' => 'tasks/folder',
                'folderPrimaryAction' => 'list',
                'itemActionView' => 'admin.tasks.item_action',
                'folderActionView' => 'admin.tasks.folder_action'
            ]);
        }
    }


    /**
     * Show the form for folder movement.
     *
     * @param  Request  $request
     * @param  string   $folderId
     * @return \Illuminate\Http\Response
     */
    public function moveFolder(Request $request, $folderId)
    {
        if (\Gate::denies('view', 'tasks')) {
            abort(403);
        }

        //Prevent method call outside ajax
        if (!$request->ajax()) {
            abort(404);
        }

        $folder = \Auth::user()->taskFolders()->findOrFail($folderId);

        $parentFolder = $folder->parent;

        if (empty($parentFolder)) {
            $parentFolder = new TaskFolder;
        }

        //Get list data
        $listData = $this->getListData($request, $parentFolder);

        return view('admin.tasks.list_modal', [
                'folders' => $listData['folders'],
                'items' => $listData['items'],
                'folder' => $parentFolder,
                'targetFolder' =>  $folder,
                'itemPath' => 'tasks/task',
                'folderPath' => 'tasks/folder',
                'folderPrimaryAction' => 'list',
            ]);
    }

    /**
     * Show the form for folder movement.
     *
     * @param  Request  $request
     * @param  string   $itemId
     * @return \Illuminate\Http\Response
     */
    public function moveItem(Request $request, $itemId)
    {
        if (\Gate::denies('view', 'tasks')) {
            abort(403);
        }

        //Prevent method call outside ajax
        if (!$request->ajax()) {
            abort(404);
        }

        $item = \Auth::user()->taskItems()->findOrFail($itemId);

        $folder = $item->taskFolder;

        if (empty($folder)) {
            $folder = new TaskFolder;
        }

        //Get list data
        $listData = $this->getListData($request, $folder);

        return view('admin.tasks.list_modal', [
                'folders' => $listData['folders'],
                'items' => $listData['items'],
                'folder' => $folder,
                'targetItem' =>  $item,
                'itemPath' => 'tasks/task',
                'folderPrimaryAction' => 'list',
                'folderPath' => 'tasks/folder',
            ]);
    }

    /**
     * Update folder parent Id.
     *
     * @param  Request  $request
     * @param  string   $folderId
     * @param  string   $newFolderId
     * @return \Illuminate\Http\Response
     */
    public function moveFolderTo(Request $request, $folderId, $newFolderId = null)
    {
        if (\Gate::denies('update', 'tasks')) {
            abort(403);
        }

        //Prevent method call outside ajax
        if (!$request->ajax()) {
            abort(404);
        }

        $folder = \Auth::user()->taskFolders()->findOrFail($folderId);

        if (empty($newFolderId)) {
            $newFolder = null;
        } else {
            $newFolder = \Auth::user()->taskFolders()->findOrFail($newFolderId)->id;
        }

        $folder->update([
                'task_folder_id' => $newFolder,
            ]);

        $request->session()->flash('flash_success_message', \Lang::get('admin/tasks.folder_moved'));

        return response()->json();
    }

    /**
     * Update item parent Id.
     *
     * @param  Request  $request
     * @param  string   $itemId
     * @param  string   $newFolderId
     * @return \Illuminate\Http\Response
     */
    public function moveItemTo(Request $request, $itemId, $newFolderId = null)
    {
        if (\Gate::denies('update', 'tasks')) {
            abort(403);
        }

        //Prevent method call outside ajax
        if (!$request->ajax()) {
            abort(404);
        }

        $item = \Auth::user()->taskItems()->findOrFail($itemId);

        if (empty($newFolderId)) {
            $newFolder = null;
        } else {
            $newFolder = \Auth::user()->taskFolders()->findOrFail($newFolderId)->id;
        }

        $item->update([
                'task_folder_id' => $newFolder,
            ]);

        $request->session()->flash('flash_success_message', \Lang::get('admin/tasks.task_moved'));

        return response()->json();
    }


    /**
     * Get list data.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Illuminate\Database\Eloquent\Model $taskFolder
     * @return array
     */
    protected function getListData(Request $request, $folder)
    {
        //Get sort data
        $sortData = $this->handleSorting->getSorting($request);

        //Get child folders
        $folders = $this->getChildFolders($sortData, $folder->id);

        //Get list items
        $items = \Auth::user()->taskItems()->where('task_folder_id', $folder->id)->orderBy($sortData["query"]["sort"], $sortData["query"]["order"])->get();

        return compact('sortData', 'folders', 'items');
    }

    /**
     * Get child folders.
     *
     * @param  array  $sortData
     * @param  int  $folderId
     * @return Illuminate\Support\Collection
     */
    protected function getChildFolders($sortData, $folderId)
    {
        //Select all user folders with items count
        $this->folders = \Auth::user()->taskFolders()->withCount('taskItems as items')->orderBy($sortData["query"]["sort"], $sortData["query"]["order"])->get();
        
        //Check if any folders exist
        if ($this->folders->isEmpty()) {
            return collect([]);
        }

        //Count all items for folder and its children
        foreach ($this->getChildren($folderId) as $folder) {
            $items = array();

            $items = $this->countItems($folder->id, $items);

            if (isset($items)) {
                $folder->items_count += array_sum($items);
            }

            $folders[] = $folder;
        }

        return isset($folders) ? collect($folders) : collect([]);
    }

    /**
     * Travers folder tree and make items array.
     *
     * @param  int $folderId
     * @param  array $items
     * @return array
     */
    protected function countItems($folderId, $items)
    {
        foreach ($this->folders as $folder) {
            if ($folder->task_folder_id == $folderId) {
                if ($folder->children->isNotEmpty()) {
                    $items = $this->countItems($folder->id, $items);
                }
                
                $items[] = $folder->items_count;
            }
        }

        return isset($items) ? $items : null;
    }

    /**
     * Get direct folder children.
     *
     * @param  int $parentId
     * @return Illuminate\Database\Eloquent\Collection
     */
    protected function getChildren($parentId)
    {
        return $this->folders->where('task_folder_id', $parentId);
    }
}
