<?php

namespace App\Http\Controllers\Tests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\HandleSorting as HandleSorting;
use App\Models\Tests\TestFolder as TestFolder;

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
     * @param  string   $testFolder
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

        dd($request);
    }
}
