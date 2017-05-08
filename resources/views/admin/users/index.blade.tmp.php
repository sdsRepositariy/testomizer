@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('admin.sidebar')
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
                        <div class="col-xs-12 col-sm-4">
                            <h4 class="text-capitalize">
                               {{ $usergroup."&nbsp;list" }}
                            </h4>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <form method="get" action="{{ url($slug) }}">
                                <div class="input-group searchbar text-right">
                                    <input type="text" class="form-control" name="search" placeholder="Search for..." value="{{ old('search') }}">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit" ><span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div>
                        @if(\Gate::allows('create', 'user'))
                        <div class="col-xs-12 col-sm-4">
                            <div class="text-right header-button">
                                <a class="btn btn-default" href="{{ url($slug, 'create') }}" data-toggle="tooltip" title="Download users from xls">
                                    <span class="glyphicon glyphicon-download-alt icon-plus"></span>
                                </a>
                                <a class="btn btn-default" href="{{ url($slug, 'create') }} " data-toggle="tooltip" title="Add new user">
                                    <span class=" glyphicon glyphicon-plus"></span>
                                </a>
                            </div>                        
                        </div>
                        @endcan  
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <h4>Filters:</h4>
                        </div>
                        @if(\Gate::allows('create', 'community'))
                        <div class="col-xs-12 col-md-3">
                             <div class="community">
                                <div class="dropdown">
                                    <button class="btn btn-default btn-block dropdown-toggle" type="button" data-toggle="dropdown">
                                        <div class="selected pull-left text-left"></div>
                                        <div class="pull-right">
                                            <span class="caret"></span>
                                        </div>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a data-selected='{{ $session["community"]=="all" ? "true" : "" }}' href="{{ url($slug.'?community=all') }}">All</a></li>
                                        <li><a data-selected='{{ $session["community"]=="my_community" ? "true" : "" }}' href="{{ url($slug.'?community=my_community') }}">My community</a></li>
                                        <li class="divider"></li>
                                        @foreach ($communities as $community)
                                        <li><a data-selected='{{ $session["community"]==$community->id ? "true" : "" }}' href="{{ url($slug.'?community='.$community->id) }}">
                                        {{ $community->city->region->name }},
                                         &nbsp;{{ $community->city->name }},
                                         &nbsp;{{ $community->name }},
                                         &nbsp;{{ $community->number }}
                                        </a></li>
                                        @endforeach
                                    </ul>
                                </div> 
                            </div>
                        </div>
                        @endif 
                        <div class="col-xs-12 col-md-2">
                            <form class="form-inline filter" action="{{ url($slug) }}" method="GET">
                                <div class="form-group">
                                    <label for="role" class="control-label">Role:</label>
                                    <select class="form-control" id="role" name="role">
                                        <option value="all" {{ $session["role"]=="all" ? "selected" : "" }}>All</option>
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->role }}" {{ $session["role"]==$role->role ? "selected" : "" }}>{{ $role->role }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="col-xs-12 col-md-2">
                            <form class="form-inline filter" action="{{ url($slug) }}" method="GET">
                                <div class="form-group">
                                    <label for="status" class="control-label">Status:</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="all" {{ $session["status"]=="all" ? "selected" : "" }}>All</option>
                                        <option value="active" {{ $session["status"]=="active" ? "selected" : "" }}>Active</option>
                                        <option value="deleted" {{ $session["status"]=="deleted" ? "selected" : "" }}>Deleted</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                            
                    </div>
                </div>
                
                <div class="table-responsive">
                    @include('admin.users.table')
               </div>
            </div>

        {{ $list->links() }}
        </div>
    </div>
</div>
@endsection