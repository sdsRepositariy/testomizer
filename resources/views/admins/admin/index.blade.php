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
                {{ \Session::get('flash_message') }}
            </div>
            @endif 
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="row">

                        <div class="col-md-3 col-xs-12">
                            <p>User list</p>
                        </div>

                        <div class="col-md-6 col-xs-6">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                </span>
                            </div>


                        </div>

                        <div class="col-md-3 col-xs-6 text-right">
                            <a class="btn btn-default" href="{{ url('/admin/create') }}">Add new user</a>
                        </div>
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
                                <th>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Status
                                            <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="#">All
                                                    <span class="glyphicon glyphicon-ok"></span>
                                                </a>
                                            </li>
                                            <li><a href="#">Active</a></li>
                                            <li><a href="#">Deleted</a></li>
                                        </ul>
                                    </div>
                                </th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $user)
                            <tr>
                                <td>{{ (($list->currentPage() - 1 ) * $list->perPage() ) + $loop->iteration }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->member->login }}</td>
                                <td>
                                    @if ( !$user->trashed() )
                                    <span class="text-success glyphicon glyphicon-ok"></span>
                                    @else
                                    <span class="text-danger glyphicon glyphicon-trash"></span>
                                    @endif
                                </td>
                                <td>
                                    @if ( !$user->trashed() )
                                    <a class="btn btn-info btn-xs" href="{{ url('/admin', $user->id) }}">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                    @else
                                    <form method="POST" action="{{ url('/admin/'.$user->member->id.'/restore') }}">
                                    {{ csrf_field() }}
                                        <button type="submit" class="btn btn-success btn-xs">
                                            <span class="glyphicon glyphicon-refresh"></span>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                                <td>
                                    @if ( !$user->trashed() )
                                    <form method="POST" action="{{ url('/admin/'.$user->id) }}">
                                    {{ method_field('DELETE') }}
                                    @else
                                    <form method="POST" action="{{ url('/admin/'.$user->member->id.'/harddelete') }}">
                                    @endif
                                    {{ csrf_field() }}
                                    
                                    @if ($user->member->role->role !== 'superadmin')
                                        <button type="submit" class="btn btn-danger btn-xs">
                                            @if ( !$user->trashed() )
                                            <span class="glyphicon glyphicon-trash"></span>
                                            @else
                                            <span class="glyphicon glyphicon-remove"></span>
                                            @endif
                                        </button>
                                    @endif
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