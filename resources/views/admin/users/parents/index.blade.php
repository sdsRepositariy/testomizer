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
            @if ( $errors->has('download_error') )
                <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    @foreach ($errors->all() as $message)
                        {{ $message }}
                    @endforeach  
                </div>
            @endif 
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <h4>
                               @lang('admin/users.parents_list')
                            </h4>
                        </div>
                        <div class="col-xs-9 col-sm-4">    
                            <div class="input-group searchbar text-right">
                                <input type="text" class="form-control" name="search" placeholder="@lang('admin/users.search_placeholder')" value="{{ old('search') }}">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" ><span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-xs-3 col-sm-4">
                            <div class="text-right header-button">
                                <a class="btn btn-default" href="{{ url($path, 'download').$queryStringWithSort }}" title="@lang('admin/users.download')">
                                    <span class="glyphicon glyphicon-export icon-plus"></span>
                                </a>
                            </div>               
                        </div>
                    </div>
                    
                    <div class="row filter-block">
                        <form id="user-filters" action="{{ url($path, 'list') }}" method="GET">
                            @if(\Gate::allows('create', 'community'))
                            <div class="col-xs-12 col-lg-2">
                                <h4>@lang('admin/users.filters')</h4>
                            </div>
                            <div class="col-xs-12 col-md-5 col-lg-4">
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
                            <div class="col-xs-12 col-md-3 col-lg-2">
                            @else
                            <div class="col-xs-12 col-md-5">
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
                    @include('admin.users.parents.table')
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