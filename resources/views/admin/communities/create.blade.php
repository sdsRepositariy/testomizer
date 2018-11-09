@extends('layouts.app')

@section('content')
<div class="container-fluid full-height">
  <div class="row">
    <div class="col-xs-12">
      @if ( session('flash_message') )
      <div class="alert alert-success alert-dismissable">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        {{ session('flash_message') }}
      </div>
      @endif
      @if ( $errors->has('community_error') )
      <div class="alert alert-danger alert-dismissable">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        {{ $errors->first('community_error') }}
      </div>
      @endif
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class='row'>

            <div class="col-sm-4 col-xs-12">
              <div class="text-left">
                <h4>
                  @if($community->exists === true)
                    @if (Request::is('*/edit'))
                      @lang('admin/settings.edit_community')
                    @else
                      @lang('admin/settings.view_community')
                    @endif
                  @else
                    @lang('admin/settings.create_community')
                  @endif
                </h4>
              </div>
            </div>

            <div class="col-sm-6 col-xs-12 col-md-5">
              <div class="text-right">
                @if($community->exists === true)
                <div class="btn-group">
                  <a class="btn btn-default" href="{{url($path, $community->id).'/edit' }}">@lang('admin/settings.edit')</a>
                </div> 
                @endif
              </div>
            </div>

            <div class="col-sm-2 col-md-offset-1 hidden-xs">
              <a class="close" href="{{ $urlCommunityList }}">@lang('admin/settings.exit')</a>
            </div>
          </div>

        </div>

        <div class="panel-body">

          @if($community->exists === true)
          <form class="form-horizontal" method="POST" action="{{ url($path, $community->id) }}">
          {{ method_field('PUT') }}
          @else
          <form class="form-horizontal" method="POST" action="{{ url($path) }}">
          {{ method_field('POST') }}
          @endif
          {{ csrf_field() }}
            
            <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
              <label for="country" class="col-md-3 control-label">@lang('admin/settings.country')</label>
              <div class="col-md-8 col-lg-6">
                <select id="country" class="form-control" name="country" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }} required>
                  <option value="" >@lang("admin/settings.select_country")</option>
                  @foreach ($countries as $country)
                  <option value="{{ $country->id }}" {{ $filter['country'] == $country->id ? 'selected' : ''}}>
                  {{ $country->name }}</option>
                  @endforeach
                </select>
                @if ($errors->has('country'))
                <span class="help-block">
                  <strong>{{ $errors->first('country') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group {{ $errors->has('region') ? ' has-error' : '' }}">
              <label for="region" class="col-md-3 control-label">@lang('admin/settings.region')</label>
              <div class="col-md-8 col-lg-6">
                <select id="region" class="form-control" name="region" required disabled>
                </select>
                @if ($errors->has('region'))
                <span class="help-block">
                  <strong>{{ $errors->first('region') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
              <label for="city" class="col-md-3 control-label">@lang('admin/settings.city')</label>
              <div class="col-md-8 col-lg-6">
                <select id="city" class="form-control" name="city" required disabled>
                </select>
                @if ($errors->has('city'))
                <span class="help-block">
                  <strong>{{ $errors->first('city') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group {{ $errors->has('community_type') ? ' has-error' : '' }}">
              <label for="community_type" class="col-md-3 control-label">@lang('admin/settings.community_type')</label>
              <div class="col-md-8 col-lg-6">
                <select id="community_type" class="form-control" name="community_type" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>
                  @foreach ($community_types as $community_type)
                  <option value="{{ $community_type->id }}" {{ $filter['community_type'] == $community_type->id ? 'selected' : ''}}>
                  {{ $community_type->name }}</option>
                  @endforeach
                </select>
                @if ($errors->has('community_type'))
                <span class="help-block">
                  <strong>{{ $errors->first('community_type') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group {{ $errors->has('number') ? ' has-error' : '' }}">
              <label for="number" class="col-md-3 control-label">@lang('admin/settings.number')</label>
              <div class="col-md-8 col-lg-6">
                <input id="number" type="text" class="form-control" name="number" value="{{ old('number', $community->number) }}" required {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'readonly' }}>

                @if ($errors->has('number'))
                <span class="help-block">
                  <strong>{{ $errors->first('number') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
              <label for="name" class="col-md-3 control-label">@lang('admin/settings.name')</label>
              <div class="col-md-8 col-lg-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $community->name) }}" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'readonly' }}>

                @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
              </div>
            </div>
            
            @if(Request::is('*/edit')||Request::is('*/create'))
            <div class="row">
              <div class="col-md-9 col-md-offset-3">
                <button type="submit" class="btn btn-primary">@lang('admin/settings.save')</button>
              </div>
            </div>
            @endif

          </form>

        </div> <!-- end <div class="panel-body"> -->
      </div> <!-- end <div class="panel panel-default"> -->
    </div> <!-- end <div class="col-md-9">-->
  </div> <!-- end <div class="row">-->
</div> <!-- end <div class="container-fluid">-->

<script>
(function($){
$(function(){

$("#country").on('change', function() {
  var selectedVal = $(this).find("option:selected").val();

  if (selectedVal != '') {
    $.ajax({
      url: "{{ url('settings/communities/getregions') }}",
      type: 'get',
      dataType: 'json',
      data: {'country': selectedVal},
      success: function(data) {
        var filter = "{{$filter['region']}}"; 

        var html = '';

        if ("{{$filter['country']}}" != selectedVal) {
          html += '<option value="" selected disabled>@lang("admin/settings.select_region")</option>';
        }
               
        for (var i=0; i<data.regions.length; i++) {

          if (filter == data.regions[i].id) {
            var selected = 'selected';
          } else {
            var selected = '';
          }

          html += '<option value="'+data.regions[i].id+'" '+selected+'>';
          html += data.regions[i].name;
          html += '</option>';
        }
        

        if("{{ Request::is('*/edit') || Request::is('*/create') }}") {
          $("#region").prop( "disabled", false ).html(html);
        } else {
          $("#region").html(html);
        }

        $( "#region" ).trigger( "change" );
      },
      error: function(data) {
        $("body").html(data.responseText);
      },
    });
  }

});

var selectedCountry = $('#country').find("option:selected").val();

if (selectedCountry == '' || selectedCountry == null) {
  $("#region").prop( "disabled", true );
} else {
  $( "#country" ).trigger( "change" );
}


$("#region").change(function() {
  var selectedVal = $(this).find("option:selected").val();

  if (selectedVal != '') {
    $.ajax({
      url: "{{ url('settings/communities/getcities') }}",
      type: 'get',
      dataType: 'json',
      data: {'region': selectedVal},
      success: function(data) {
        var filter = "{{$filter['city']}}";

        var html = '';

        if ("{{$filter['region']}}" != selectedVal) {
          html += '<option value="" selected disabled>@lang("admin/settings.select_city")</option>';
        } 

        for (var i=0; i<data.cities.length; i++) {

          if (filter == data.cities[i].id) {
            var selected = 'selected';
          } else {
            var selected = '';
          }
          html += '<option value="'+data.cities[i].id+'" '+selected+'>';
          html += data.cities[i].name;
          html += '</option>';
        }

        if("{{ Request::is('*/edit') || Request::is('*/create') }}") {
          $("#city").prop( "disabled", false ).html(html);
        } else {
          $("#city").html(html);
        }

      },
      error: function(data) {
        $("body").html(data.responseText);
      },
    });
  }
});

var selectedRegion = $('#region').find("option:selected").val();

if (selectedRegion == '' || selectedRegion == null) {
  $("#city").prop( "disabled", true );
} else {
  $( "#region" ).trigger( "change" );
}

//Add required mark
var required = $("[required]").parent().prev().append('<span>*</span>').find('span').addClass('required-mark');

$("input:not([required]), select").parent().prev().append('&nbsp;');

});
})(jQuery);  
</script>

@endsection