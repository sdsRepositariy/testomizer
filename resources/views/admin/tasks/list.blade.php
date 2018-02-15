@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('admin.sidebar')
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Panel title</h4>
                </div>
                <div class="panel-body">
                    <task-list></task-list>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection