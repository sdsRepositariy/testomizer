<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tasks\TaskItem as TaskItem;
use App\Http\Requests\ValidateTaskForm as ValidateTaskForm;

class ItemController extends Controller
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
            'data' => new TaskItem(),
            'action' => action('Tasks\ItemController@store'),
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
        $task = new TaskItem();

        $task->fill([
            'user_id' => \Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'task_folder_id' => $parentFolder,
        ]);

        $task->save();

        $request->session()->flash('flash_success_message', \Lang::get('admin/tasks.task_created'));

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

        $item = \Auth::user()->taskItems()->findOrFail($id);

        return view('admin.tasks.create', [
            'data' => $item,
            'action' => action('Tasks\ItemController@update', [$item->id])
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

        $item = \Auth::user()->taskItems()->findOrFail($id);

        return view('admin.tasks.create', [
            'data' => $item,
            'action' => action('Tasks\ItemController@update', [$item->id])
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
        $item = \Auth::user()->taskItems()->findOrFail($id);

        $item->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

        $request->session()->flash('flash_success_message', \Lang::get('admin/tasks.task_updated'));

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
            'name' => \Auth::user()->taskItems()->findOrFail($id)->name,
            'action' => action('Tasks\ItemController@destroy', [$id])
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

        $item = \Auth::user()->taskItems()->findOrFail($id);

        $item->delete();

        $request->session()->flash('flash_success_message', \Lang::get('admin/tasks.task_deleted'));

        return response()->json();
    }
}
