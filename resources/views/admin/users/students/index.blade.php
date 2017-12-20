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
                            <h4>
                               @lang('admin/users.students_list')
                            </h4>
                        </div>
                        @if(\Gate::allows('create', 'user'))
                        <div class="col-xs-12 col-sm-4">
                        @else
                        <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                        @endif                         
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
                                <button type="button" class="btn btn-default" id="callupload" data-toggle="tooltip" title="Upload users from xls">
                                    <span class="glyphicon glyphicon-export icon-plus"></span>
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="upload" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                <h4 class="modal-title text-left">Select file for upload</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="upload.php" method="post" enctype="multipart/form-data">
                                                    <input type="file" name="fileToUpload" id="fileToUpload">
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Upload</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if(\Gate::allows('create', 'user'))
                                <a class="btn btn-default" href="{{ url($path, 'upload') }}" title="@lang('admin/users.upload_students')">
                                    <span class="glyphicon glyphicon-import icon-plus"></span>
                                </a>
                                <a class="btn btn-default" href="{{ url($path.'/user', 'create') }} " title="@lang('admin/users.add_user')">
                                    <span class=" glyphicon glyphicon-plus"></span>
                                </a>
                                @endif  
                            </div>               
                        </div>
                    </div>
                    
                    <div class="row filter-block">
                        <form id="user-filters" action="{{ url($path, 'list') }}" method="GET">
                            @if(\Gate::allows('create', 'community'))
                            <div class="col-xs-12">
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
                            <div class="col-xs-12 col-md-3">                 
                            @endif
                                <div>@lang('admin/users.period')</div>
                                <select name="period" class="form-control">
                                    @foreach ($periods as $period)
                                    <option {{ $filterGrade["period"]==$period->id ? "selected" : "" }} value="{{ $period->id }}">
                                    {{ $period->getPeriod() }}
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
                            <div class="col-xs-12 col-md-2">
                                <div>@lang('admin/users.level')</div>
                                <select name="level" class="form-control">
                                    <option {{ $filterGrade["level"]==null ? "selected" : "" }} value="">@lang('admin/users.all')</option>
                                    <option disabled>----------</option>
                                    @foreach ($levels as $level)
                                    <option {{ $filterGrade["level"]==$level->id ? "selected" : "" }} value="{{ $level->id }}">
                                    {{ $level->number }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-2">
                                <div>@lang('admin/users.stream')</div>
                                <select name="stream" class="form-control">
                                    <option {{ $filterGrade["stream"]==null ? "selected" : "" }} value="">@lang('admin/users.all')</option>
                                    <option disabled>---------</option>
                                    @foreach ($streams as $stream)
                                    <option {{ $filterGrade["stream"]==$stream->id ? "selected" : "" }} value="{{ $stream->id }}">{{ $stream->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="table-responsive">
                    @include('admin.users.students.table')
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

});
})(jQuery);   
</script>
@endsection