<?php

namespace App\Http\Controllers\Tests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tests\TestFolder as TestFolder;
use App\Http\Requests\ValidateListForm as ValidateListForm;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (\Gate::denies('create', 'tests')) {
            abort(403);
        }

        return view('admin.tests.create', [
            'data' => new TestFolder(),
            'action' => action('Tests\FolderController@store'),
            'parentFolder' => $request->parent_folder
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateListForm $request)
    {
        //Check if parent exist
        if (isset($request->parent_folder)) {
            $parentFolder = TestFolder::findOrFail($request->parent_folder)->id;
        } else {
            $parentFolder = null;
        }
        
        //Store data
        $testFolder = new TestFolder;

        $testFolder->fill([
            'name' => $request->name,
            'description' => $request->description,
            'test_folder_id' => $parentFolder,
        ]);

        $testFolder->save();

        $request->session()->flash('flash_success_message', \Lang::get('admin/tests.folder_created'));

        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (\Gate::denies('view', 'tests')) {
            abort(403);
        }

        $testFolder = TestFolder::findOrFail($id);

        return view('admin.tests.create', [
            'data' => $testFolder,
            'action' => action('Tests\FolderController@update', [$testFolder->id])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Gate::denies('update', 'tests')) {
            abort(403);
        }

        $testFolder = TestFolder::findOrFail($id);

        return view('admin.tests.create', [
            'data' => $testFolder,
            'action' => action('Tests\FolderController@update', [$testFolder->id])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ValidateListForm $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidateListForm $request, $id)
    {
        $testFolder = TestFolder()->findOrFail($id);

        $testFolder->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

        $request->session()->flash('flash_success_message', \Lang::get('admin/tests.folder_updated'));

        return response()->json();
    }

    /**
     * Display the warning for destroy method.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        if (\Gate::denies('delete', 'tests')) {
            abort(403);
        }

        return view('components.delete', [
            'name' => TestFolder::findOrFail($id)->name,
            'action' => action('Tests\FolderController@destroy', [$id])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (\Gate::denies('delete', 'tests')) {
            abort(403);
        }

        //Get selected folder
        $testFolder = TestFolder::findOrFail($id);

        //Get all folders
        $testFolders = TestFolder::withCount('testItems as items')->get();

        //Check if folder can be deleted
        if ($testFolders->isNotEmpty()) {
            //Count test items for selected folder
            $items =  $testFolder->testItems()->count();

            //Count test items for children folders
            $childItems = array();

            $childItems = $this->countItems($testFolders, $testFolder->id, $childItems);

            //Check if test item exist in chidren folders
            if (isset($childItems)) {
                $childItems = array_sum($childItems);
            } else {
                $childItems = 0;
            }

            //Check if test items exist in child folder
            if (isset($items)) {
                $items += $childItems;
            } else {
                $items = $childItems;
            }

            //Final check for items
            if ($items > 0) {
                return response()->json(['error' => \Lang::get('admin/tests.unable_delete_folder')], 400);
            }
        }

        //Delete the folder
        $testFolder->delete();

        $request->session()->flash('flash_success_message', \Lang::get('admin/tests.folder_deleted'));

        return response()->json($items);
    }

    /**
     * Travers folder tree and make items array.
     *
     * @param  Illuminate\Database\Eloquent\Collection $testFolders
     * @param  int $folderId
     * @param  array $items
     * @return array
     */
    protected function countItems($testFolders, $folderId, $items)
    {
        foreach ($testFolders as $folder) {
            if ($folder->test_folder_id == $folderId) {
                if ($folder->children->isNotEmpty()) {
                    $items = $this->countItems($testFolders, $folder->id, $items);
                }
                $items[] = $folder->items_count;
            }
        }
        return isset($items) ? $items : null;
    }
}
