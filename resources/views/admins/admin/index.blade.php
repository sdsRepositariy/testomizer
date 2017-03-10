@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('admins.sidebar')
        </div>
        <div class="col-md-9">
            @if ( \Session::has('flash_message') )
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                {{\Session::get('flash_message')}}
            </div>
            @endif 
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="pull-left">User list</div>
                    <div class="pull-right">
                        <a class="btn btn-default" href="{{url('/admin/create')}}">Add new user</a>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Last name</th>
                                <th>First name</th>
                                <th>Email</th>
                                <th>Login</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $user)
                            <tr>
                                <td>{{ (($list->currentPage() - 1 ) * $list->perPage() ) + $loop->iteration }}</td>
                                <td>{{$user->last_name}}</td>
                                <td>{{$user->first_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->member->login}}</td>
                                <td>
                                    <a class="btn btn-info btn-xs" href="{{url('/admin', $user->id)}}">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                </td>
                                <td>
                                    <form method="POST" action="{{ url('/admin/'.$user->id)}}">
                                    {{ csrf_field() }}
                                    {{method_field('DELETE')}}
                                        <button type="submit" class="btn btn-danger btn-xs">
                                            <span class="glyphicon glyphicon-remove"></span>
                                        </button>
                                    </form> 
                                </td>
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