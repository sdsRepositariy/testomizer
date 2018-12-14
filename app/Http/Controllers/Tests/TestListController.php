<?php

namespace App\Http\Controllers\Tests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\HandleSorting as HandleSorting;
use App\Models\Tests\TestFolder as TestFolder;
use App\Models\Tests\TestItem as TestItem;

class TestListController extends Controller
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
    protected $sessionKey = "test_list";

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
     * @param  string   $folderId
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request, $folderId = null)
    {
        if (\Gate::denies('view', 'tests')) {
            abort(403);
        }
        
        if (empty($folderId)) {
            $folder = new TestFolder;
        } else {
            $folder = TestFolder::findOrFail($folderId);
        }

        //Get list data
        $listData = $this->getListData($request, $folder);

        return view('admin.tests.list', [
            'folders' => $listData['folders'],
            'items' => $listData['items'],
            'sortData' => $listData['sortData'],
            'folder' => $folder,
            'actionMenu' => 'admin.tests.test_action_menu',
            'itemPath' => 'tests/test',
            'folderPath' => 'tests/folder',
            'folderPrimaryAction' => 'list',
            'itemActionView' => 'admin.tests.item_action',
            'folderActionView' => 'admin.tests.folder_action'
        ]);
    }

    /**
     * Get list data.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Illuminate\Database\Eloquent\Model $testFolder
     * @return array
     */
    protected function getListData(Request $request, $folder)
    {
        //Get sort data
        $sortData = $this->handleSorting->getSorting($request);

        //Get child folders
        $folders = $this->getChildFolders($sortData, $folder->id);

        //Get list items
        $items = TestItem::where('test_folder_id', $folder->id)->orderBy($sortData["query"]["sort"], $sortData["query"]["order"])->get();

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
        $this->folders = TestFolder::withCount('testItems as items')->orderBy($sortData["query"]["sort"], $sortData["query"]["order"])->get();
        
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
            if ($folder->test_folder_id == $folderId) {
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
        return $this->folders->where('test_folder_id', $parentId);
    }
}
