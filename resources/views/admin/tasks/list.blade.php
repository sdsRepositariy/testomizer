@extends('admin.tasks.index')

@section('tasks')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Panel title</h4>
        </div>
        <div class="panel-body">
            <task-list></task-list>
        </div>
    </div>
@endsection