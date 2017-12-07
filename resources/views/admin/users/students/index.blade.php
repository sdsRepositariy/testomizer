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
                               @lang('admin/users.students_list')
                            </h4>
                        </div>
                        @if(\Gate::allows('create', 'user'))
                        <div class="col-xs-12 col-sm-4">
                        @else
                        <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                        @endif
                            <form method="get" action="{{ url($path, 'list') }}">
                                <div class="input-group searchbar text-right">
                                    <input type="text" class="form-control" name="search" placeholder="@lang('admin/users.search_placeholder')" value="{{ old('search') }}">
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
                                <button type="button" class="btn btn-default" id="callupload" data-toggle="tooltip" title="@lang('admin/users.upload_students')">
                                    <span class="glyphicon glyphicon-download-alt icon-plus"></span>
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="upload" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                <h4 class="modal-title text-left">@lang('admin/users.select_file_upload')</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form action="upload.php" method="post" enctype="multipart/form-data">
                                                    <input type="file" name="fileToUpload" id="fileToUpload">
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('admin/users.close')</button>
                                                <button type="button" class="btn btn-primary">@lang('admin/users.upload')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a class="btn btn-default" href="{{ url($path, 'create') }} " data-toggle="tooltip" title="@lang('admin/users.add_user')">
                                    <span class=" glyphicon glyphicon-plus"></span>
                                </a>
                            </div>                        
                        </div>
                        @endcan  
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
                                    <option {{ $filterGrade["period"]==$period->period_id ? "selected" : "" }} value="{{ $period->period_id }}">
                                    {{ $period->year_start }} : {{ $period->year_end }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-2">
                                <div>@lang('admin/users.status')</div>
                                <select name="status" class="form-control">
                                    <option {{ $filterUser["status"]==null ? "selected" : "" }} value="">@lang('admin/users.all')   
                                    </option> 
                                    <option disabled>----------</option>
                                    <option {{ $filterUser["status"]=="active" ? "selected" : "" }} value="active">@lang('admin/users.active')</option>
                                    <option {{ $filterUser["status"]=="deleted" ? "selected" : "" }}' value="deleted">@lang('admin/users.deleted')</option> 
                                </select>
                            </div>                     
                            <div class="col-xs-12 col-md-2">
                                <div>@lang('admin/users.level')</div>
                                <select name="level" class="form-control">
                                    <option {{ $filterGrade["level"]==null ? "selected" : "" }} value="">@lang('admin/users.all')</option>
                                    <option disabled>----------</option>
                                    @foreach ($levels as $level)
                                    <option {{ $filterGrade["level"]==$level->number ? "selected" : "" }} value="{{ $level->number }}">
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
                                    <option {{ $filterGrade["stream"]==$stream->name ? "selected" : "" }} value="{{ $stream->name }}">{{ $stream->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="table-responsive">
                
               </div>
            </div>

        {{ $list->links() }}
        </div>
    </div>
</div>

<script type="text/javascript">
(function($){
$(function(){

$("#user-filters select").change(function() {
    var parameters = [];
    $('select').each(function(index) {
        if($(this).val() != "") {
            parameters[index] = {
                name: $(this).attr('name'), value : $(this).val()
            };
        }
    });
    console.log(parameters)
});

//Call the modal for file upload
$("#callupload").click(function(){
    $("select").modal();
});

});
})(jQuery);   
</script>
@endsection