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
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request)
    {
        if (\Gate::denies('view', 'tasks')) {
            abort(403);
        }
 
        $taskFolder = new TaskFolder;

        return $this->buildList($request, $taskFolder);
    }

    /**
     * Get the sublist.
     *
     * @param  Request  $request
     * @param  string   $taskFolder
     * @return \Illuminate\Http\Response
     */
    public function getSublist(Request $request, $taskFolder)
    {
        if (\Gate::denies('view', 'tasks')) {
            abort(403);
        }

        //Get folder
        $taskFolder = \Auth::user()->taskFolders()->findOrFail($taskFolder);

        return $this->buildList($request, $taskFolder);
    }

    /**
     * Show the form for folder movement.
     *
     * @param  Request  $request
     * @param  string   $taskFolder
     * @return \Illuminate\Http\Response
     */
    public function moveFolder(Request $request, $taskFolder)
    {
        if (\Gate::denies('view', 'tasks')) {
            abort(403);
        }

        //Get parent folder
        $parentFolder = \Auth::user()->taskFolders()->findOrFail($taskFolder)->parent;

        if (empty($parentFolder)) {
            $parentFolder = new TaskFolder;
        }

        return $this->buildList($request, $parentFolder);
    }

    public function moveItem()
    {
        //
    }

    public function moveFolderTo()
    {
        //
    }

    public function moveItemTo()
    {
        //
    }


    /**
     * Build view.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Illuminate\Database\Eloquent\Model $taskFolder
     * @return Illuminate\View\View
     */
    protected function buildList($request, $taskFolder)
    {
        //Get sort data
        $sortData = $this->handleSorting->getSorting($request);

        //Get child folders
        $folders = $this->getChildFolders($sortData, $taskFolder->id);

        //Get list items
        $items = \Auth::user()->taskItems()->where('task_folder_id', $taskFolder->id)->orderBy($sortData["query"]["sort"], $sortData["query"]["order"])->get();

        //Folder menu
        $folderPath = 'tasks/folder';

        //Item menu
        $itemPath = 'tasks/list';

        //Action menu
        $actionMenu = [
            "title" => "create",
            "actions" => [
                "create_folder" => action('Tasks\FolderController@create'),
                "create_item" => action('Tasks\ItemController@create'),
            ],
        ];

        $folderAction = 'admin.tasks.folder_action';

        $itemAction = 'admin.tasks.item_action';

        if ($request->ajax()) {
            return view('admin.tasks.move', compact('folders', 'taskFolder', 'items', 'sortData', 'folderPath', 'itemPath'));
        } else {
            return view('admin.tasks.list', compact('folders', 'taskFolder', 'items', 'sortData', 'actionMenu', 'folderPath', 'itemPath', 'folderAction', 'itemAction'));
        }
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

            $items = $this->countItems($folder->id);
            
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
     * @return array
     */
    protected function countItems($folderId)
    {
        foreach ($this->folders as $folder) {
            if ($folder->task_folder_id == $folderId) {
                if ($folder->children->isNotEmpty()) {
                    $items = $this->countItems($folder->id);
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
