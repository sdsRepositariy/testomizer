@extends('layouts.app')

@section('content')
<div class="container-fluid full-height">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <h4>
                               @lang('admin/settings.communities_list')
                            </h4>
                        </div>
                        
                        <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                            <div class="text-right header-button">
                                <a class="btn btn-default" href="{{ url($path, 'create') }} " title="@lang('admin/settings.add_community')">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </a>
                            </div>               
                        </div>
                    </div>
                    
                    <div class="row filter-block">
                        <form id="community-filters" action="{{ url($path) }}" method="GET">
                            <div class="col-xs-12">
                                <h4>@lang('admin/settings.filters')</h4>
                            </div>
                            <div class="col-xs-12 col-md-3">
                                <div>@lang('admin/settings.country')</div> 
                                <select name="country" class="form-control">
                                    @foreach ($countries as $country)
                                    <option {{ $filter["country"]==$country->id ? "selected" : "" }} value="{{ $country->id }}">{{ $country->name }}
                                    </option>
                                    @endforeach                         
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-3">
                                <div>@lang('admin/settings.region')</div>
                                <select name="region" class="form-control">   
                                    <option {{ $filter["region"]==null ? "selected" : "" }} value="">@lang('admin/settings.all')</option>
                                    <option disabled>----------</option>
                                    @foreach ($regions as $region)
                                    <option {{ $filter["region"]==$region->id ? "selected" : "" }} value="{{ $region->id }}">
                                    {{ $region->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>                 
                            <div class="col-xs-12 col-md-3">
                                <div>@lang('admin/settings.city')</div>
                                <select name="city" class="form-control">
                                    <option {{ $filter["city"]==null ? "selected" : "" }} value="">@lang('admin/settings.all')</option>
                                    <option disabled>----------</option>
                                    @foreach ($cities as $city)
                                    <option {{ $filter["city"]==$city->id ? "selected" : "" }} value="{{ $city->id }}">
                                    {{ $city->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-3">
                                <div>@lang('admin/settings.community_type')</div>
                                <select name="community_type" class="form-control">
                                    <option {{ $filter["community_type"]==null ? "selected" : "" }} value="">@lang('admin/settings.all')</option>
                                    <option disabled>----------</option>
                                    @foreach ($types as $type)
                                    <option {{ $filter["community_type"]==$type->id ? "selected" : "" }} value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="table-responsive">
                    @include('admin.communities.table')
               </div>
            </div>

        {{ $list->links() }}
        </div>
    </div>
    @if ( \Session::has('flash_message') )
        <div class="snackbar-toggle" data-snackbar-type="success">{{ \Session::get('flash_message') }}</div>
    @elseif (\Session::has('flash_error_message'))
        <div class="snackbar-toggle" data-snackbar-type="error">{{ \Session::get('flash_error_message') }}</div>
    @endif
</div>
<script>
(function($){
$(function(){

$("#community-filters select").change(function() {
    var name = $(this).attr('name');

    //Disable empty selects
    $('select option:selected').each(function() {
        if($(this).val() == "") {
            $(this).attr('disabled', 'disabled');
        }
    });

    //Disable all selects next to selected
    $('select[name='+name+']')
        .parent('div')
            .nextAll('div')
                .find('option')
                    .attr('disabled', 'disabled');

    $("#community-filters").submit();
});

});
})(jQuery);   
</script>
@endsection