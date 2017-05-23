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
                        @if(\Gate::allows('create', 'user'))
                        <div class="col-xs-12 col-sm-4">
                        @else
                        <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                        @endif
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
                                @if($usergroup != 'parents')
                                <a class="btn btn-default" href="{{ url($slug, 'create') }} " data-toggle="tooltip" title="Add new user">
                                    <span class=" glyphicon glyphicon-plus"></span>
                                </a>
                                @endif
                            </div>                        
                        </div>
                        @endcan  
                    </div>
                    
                    <div class="row filter-block">
                        <div class="col-xs-12 col-md-2">
                            <h4>Filters:</h4>
                        </div>
                        @if(\Gate::allows('create', 'community'))
                        <div class="col-xs-12 col-md-2">
                             <div>Community</div>
                             <form class="filter" action="{{ url($slug) }}" method="GET">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        <div class="selected text-left"></div>
                                        <span class="caret"></span>
                                    </button>
                                    <input type="text" hidden value="" name="community">
                                    <ul class="dropdown-menu">
                                        <li data-selected='{{ $session["community"]=="all" ? "true" : "" }}' data-value="all">All</li>
                                        <li data-selected='{{ $session["community"]=="my_community" ? "true" : "" }}' data-value="my_community">My community</a></li>
                                        <li class="divider"></li>
                                        @foreach ($communities as $community)
                                        <li data-selected='{{ $session["community"]==$community->id ? "true" : "" }}' data-value="{{ $community->id }}">
                                        {{ $community->city->region->name }},
                                         &nbsp;{{ $community->city->name }},
                                         &nbsp;{{ $community->name }},
                                         &nbsp;{{ $community->number }}
                                        </li>
                                        @endforeach
                                    </ul>
                                </div> 
                            </form>
                        </div>
                        @endif
                        @if(\Gate::allows('create', 'user') && $usergroup == "teachers")
                        <div class="col-xs-12 col-md-2">
                            <div>Role</div>
                             <form class="filter" action="{{ url($slug) }}" method="GET">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        <div class="selected text-left"></div>
                                        <span class="caret"></span>
                                    </button>
                                    <input type="text" hidden value="" name="role">
                                    <ul class="dropdown-menu">
                                        <li data-selected='{{ $session["role"]=="all" ? "true" : "" }}' data-value="all">All</li>
                                        <li class="divider"></li>
                                        @foreach ($roles as $role)
                                        <li data-selected='{{ $session["role"]==$role->role ? "true" : "" }}' data-value="{{ $role->role }}">
                                        {{ $role->role }}
                                        </li>
                                        @endforeach
                                    </ul>
                                </div> 
                            </form>
                        </div>
                        @endif
                        <div class="col-xs-12 col-md-2">
                            <div>Status</div>
                            <form class="filter" action="{{ url($slug) }}" method="GET">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        <div class="selected text-left"></div>
                                        <span class="caret"></span>
                                    </button>
                                    <input type="text" hidden value="" name="status">
                                    <ul class="dropdown-menu">
                                        <li data-selected='{{ $session["status"]=="all" ? "true" : "" }}' data-value="all">All</li>
                                        <li class="divider"></li>
                                        <li data-selected='{{ $session["status"]=="active" ? "true" : "" }}' data-value="active">Active</li>
                                        <li data-selected='{{ $session["status"]=="deleted" ? "true" : "" }}' data-value="deleted">Deleted</li>
                                    </ul>
                                </div> 
                            </form>
                        </div>
                        @if($usergroup == "students" || $usergroup == "parents")  
                        <div class="col-xs-12 col-md-2">
                            <div>Level</div>
                             <form class="filter" action="{{ url($slug) }}" method="GET">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        <div class="selected text-left"></div>
                                        <span class="caret"></span>
                                    </button>
                                    <input type="text" hidden value="" name="level">
                                    <ul class="dropdown-menu">
                                        <li data-selected='{{ $session["level"]=="all" ? "true" : "" }}' data-value="all">All</li>
                                        <li class="divider"></li>
                                        @foreach ($levels as $level)
                                        <li data-selected='{{ $session["level"]==$level->number ? "true" : "" }}' data-value="{{ $level->number }}">
                                        {{ $level->number }}
                                        </li>
                                        @endforeach
                                    </ul>
                                </div> 
                            </form>
                        </div> 
                        <div class="col-xs-12 col-md-2">
                            <div>Stream</div>
                             <form class="filter" action="{{ url($slug) }}" method="GET">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        <div class="selected text-left"></div>
                                        <span class="caret"></span>
                                    </button>
                                    <input type="text" hidden value="" name="stream">
                                    <ul class="dropdown-menu">
                                        <li data-selected='{{ $session["stream"]=="all" ? "true" : "" }}' data-value="all">All</li>
                                        <li class="divider"></li>
                                        @foreach ($streams as $stream)
                                        <li data-selected='{{ $session["stream"]==$stream->name ? "true" : "" }}' data-value="{{ $stream->name }}">
                                        {{ $stream->name }}
                                        </li>
                                        @endforeach
                                    </ul>
                                </div> 
                            </form>
                        </div> 
                        <div class="col-xs-12 col-md-2">
                            <div>Period</div>
                             <form class="filter" action="{{ url($slug) }}" method="GET">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                        <div class="selected text-left"></div>
                                        <span class="caret"></span>
                                    </button>
                                    <input type="text" hidden value="" name="period">
                                    <ul class="dropdown-menu">
                                        @foreach ($periods as $period)
                                        <li data-selected='{{ $session["period"]==$period->period() ? "true" : "" }}' data-value="{{ $period->period() }}">
                                        {{ $period->period() }}
                                        </li>
                                        @endforeach
                                    </ul>
                                </div> 
                            </form>
                        </div>
                        @endif     
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