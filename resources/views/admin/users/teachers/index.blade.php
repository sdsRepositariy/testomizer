@extends('layouts.app')

@section('content')
<div class="container-fluid full-height">
    <div class="row">
        <div class="col-xs-12">
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
                            <h4>
                               @lang('admin/users.teachers_list')
                            </h4>
                        </div>
                        <div class="col-xs-12 col-sm-4">                     
                            <div class="input-group searchbar text-right">
                                <input type="text" class="form-control" name="search" placeholder="@lang('admin/users.search_placeholder')" value="{{ old('search') }}">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" ><span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-4">
                            <div class="text-right header-button">
                                @if(\Gate::allows('create', 'user'))
                                <a class="btn btn-default" href="{{ url($path, 'upload') }}" title="@lang('admin/users.upload_teachers')">
                                    <span class="glyphicon glyphicon-import icon-plus"></span>
                                </a>
                                <a class="btn btn-default" href="{{ url($path.'/user', 'create') }} " title="@lang('admin/users.add_user')">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </a>
                                @endif  
                            </div>               
                        </div>
                    </div>
                    
                    <div class="row filter-block">
                        <form id="user-filters" action="{{ url($path, 'list') }}" method="GET">
                            @if(\Gate::allows('create', 'community'))
                            <div class="col-xs-12 col-md-4">
                                <h4>@lang('admin/users.filters')</h4>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div>@lang('admin/users.community')</div> 
                                <select name="community" class="form-control">
                                    @foreach ($communities as $community)
                                    <option {{ $filterUser["community"]==$community->id ? "selected" : "" }} value="{{ $community->id }}">{{ $community->city->region->name }},
                                    &nbsp;{{ $community->city->name }},
                                    &nbsp;{{ $community->name }},
                                    &nbsp;{{ $community->number }}
                                    </option>
                                    @endforeach                         
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-2">
                            @else
                            <div class="col-xs-12 col-md-3">
                                <h4>@lang('admin/users.filters')</h4>
                            </div>
                            <div class="col-xs-12 col-md-3 col-md-offset-4">                 
                            @endif
                                <div>@lang('admin/users.role')</div>
                                <select name="role" class="form-control">
                                    <option {{ $filterUser["role"]==null ? "selected" : "" }} value="">@lang('admin/users.all')</option>
                                    <option disabled>----------</option>
                                    @foreach ($roles as $role)
                                    <option {{ $filterUser["role"]==$role->id ? "selected" : "" }} value="{{ $role->id }}">
                                    {{ ucfirst($role->role) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-2">
                                <div>@lang('admin/users.status')</div>
                                <select name="status" class="form-control">
                                    <option {{ $filterUser["status"]=="active" ? "selected" : "" }} value="active">@lang('admin/users.active')</option>
                                    <option {{ $filterUser["status"]=="deleted" ? "selected" : "" }} value="deleted">@lang('admin/users.deleted')</option> 
                                </select>
                            </div>                     
                        </form>
                    </div>
                </div>
                
                <div class="table-responsive">
                    @include('admin.users.teachers.table')
               </div>
            </div>

        {{ $list->links() }}
        </div>
    </div>
</div>

<script>
(function($){
$(function(){

//Submit not empty filters
$("#user-filters select").change(function() {
    $('select option:selected').each(function() {
        if($(this).val() == "") {
            $(this).attr('disabled', 'disabled');
        }
    });
    $("#user-filters").submit();
});

//Submit search
$('.searchbar button').click(function() {
    var input = $('input[name="search"]').val();
    window.location = "{!! url($path, 'list').$queryString !!}"+'&search='+input;
});

//Submit file name for dowload
$('#submit_download').click(function() {
    $('#download form').submit();
});


});
})(jQuery);   
</script>
@endsection