<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tasks\TaskFolder as TaskFolder;
use App\Http\Requests\ValidateTaskForm as ValidateTaskForm;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
        if (\Gate::denies('create', 'tasks')) {
            abort(403);
        }

        return view('admin.tasks.create', [
            'data' => new TaskFolder(),
            'action' => action('Tasks\FolderController@store'),
            'parentFolder' => $request->parent_folder
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ValidateTaskForm $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateTaskForm $request)
    {
        //Check if parent exist
        if (isset($request->parent_folder)) {
            $parentFolder = \Auth::user()->taskFolders()->findOrFail($request->parent_folder)->id;
        } else {
            $parentFolder = null;
        }
        

        //Store data
        $taskFolder = new TaskFolder;

        $taskFolder->fill([
            'user_id' => \Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'task_folder_id' => $parentFolder,
        ]);

        $taskFolder->save();

        $request->session()->flash('flash_success_message', \Lang::get('admin/tasks.folder_created'));

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
        if (\Gate::denies('view', 'tasks')) {
            abort(403);
        }

        $taskFolder = \Auth::user()->taskFolders()->findOrFail($id);

        return view('admin.tasks.create', [
            'data' => $taskFolder,
            'action' => action('Tasks\FolderController@update', [$taskFolder->id])
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
        if (\Gate::denies('update', 'tasks')) {
            abort(403);
        }

        $taskFolder = \Auth::user()->taskFolders()->findOrFail($id);

        return view('admin.tasks.create', [
            'data' => $taskFolder,
            'action' => action('Tasks\FolderController@update', [$taskFolder->id])
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ValidateTaskForm $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidateTaskForm $request, $id)
    {
        $taskFolder = \Auth::user()->taskFolders()->findOrFail($id);

        $taskFolder->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

        $request->session()->flash('flash_success_message', \Lang::get('admin/tasks.folder_updated'));

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
        if (\Gate::denies('delete', 'tasks')) {
            abort(403);
        }

        return view('components.delete', [
            'name' => \Auth::user()->taskFolders()->findOrFail($id)->name,
            'action' => action('Tasks\FolderController@destroy', [$id])
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
        if (\Gate::denies('delete', 'tasks')) {
            abort(403);
        }

        //Get selected folder
        $taskFolder = \Auth::user()->taskFolders()->findOrFail($id);

        //Get all folders for the user
        $taskFolders = \Auth::user()->taskFolders()->withCount('taskItems as items')->get();

        //Check if folder can be deleted
        if ($taskFolders->isNotEmpty()) {
            //Count tasks for selected folder
            $items =  $taskFolder->taskItems()->count();

            //Count tasks for children folders
            $childItems = $this->countItems($taskFolders, $taskFolder->id);

            //Check if tasks exist in chidren folders
            if (isset($childItems)) {
                $childItems = array_sum($childItems);
            } else {
                $childItems = 0;
            }

            //Check if tasks exist in child folder
            if (isset($items)) {
                $items += $childItems;
            } else {
                $items = $childItems;
            }

            //Final check for items
            if ($items > 0) {
                return response()->json(['error' => \Lang::get('admin/tasks.unable_delete_folder')], 400);
            }
        }

        //Delete the folder
        $taskFolder->delete();

        $request->session()->flash('flash_success_message', \Lang::get('admin/tasks.folder_deleted'));

        return response()->json($items);
    }

    /**
     * Travers folder tree and make items array.
     *
     * @param  Illuminate\Database\Eloquent\Collection $taskFolders
     * @param  int $folderId
     * @return array
     */
    protected function countItems($taskFolders, $folderId)
    {
        foreach ($taskFolders as $folder) {
            if ($folder->task_folder_id == $folderId) {
                if ($folder->children->isNotEmpty()) {
                    $items = $this->countItems($taskFolders, $folder->id);
                }
                $items[] = $folder->items_count;
            }
        }
        return isset($items) ? $items : null;
    }
}
