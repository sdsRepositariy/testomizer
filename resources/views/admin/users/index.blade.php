@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('admin.sidebar')
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="pull-left">User list</div>
                    <div class="pull-right">
                        <a class="btn btn-default" href="{{url('/users/create')}}">Add new user</a>
                    </div>
                </div>

                @if ( \Session::has('flash_message') )
                <div class="panel-body">
                    <div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{\Session::get('flash_message')}}
                    </div>
                </div>
                @endif 
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $user)
                            <tr>
                                <td>
                                    {{$user->first_name}}&nbsp;
                                    {{$user->middle_name}}&nbsp;
                                    {{$user->last_name}}
                                </td>
                                <td>{{$user->email}}</td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        {{ $list->links() }}
        </div>
    </div>
</div>
@endsection