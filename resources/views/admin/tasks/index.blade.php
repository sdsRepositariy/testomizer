@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('admin.sidebar')
        </div>
        <div id="task_manager" class="col-md-9">
            @yield('tasks')
        </div>
    </div>
</div>
@endsection