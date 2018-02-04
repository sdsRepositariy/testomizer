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
      @if ( $errors->has('row') )
      <div class="alert alert-danger alert-dismissable">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        @foreach ($errors->all() as $message)
        {{ $message }}
        @endforeach  
      </div>
      @endif 
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <div class='row'>
            <div class="col-xs-12 col-sm-6">
              <h4>
                @lang('admin/users.upload_teachers')
              </h4>
            </div>
            <div class="col-sm-2 col-sm-offset-4 hidden-xs">
              <a class="close" href="{{ $urlUserList }}">@lang('admin/users.exit')</a>
            </div>
          </div>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-offset-2 col-md-9 col-lg-8">
              <p class="text-warning text-justify">@lang('admin/users.attention_teachers')</p>
              <p><img id="sheet" src="<?php echo asset("img/teachers_sheet.jpg")?>" alt="sheet" class="img-responsive"></p>
            </div>
          </div>
          <form action="{{ url($path, 'upload') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
          {{ csrf_field() }}
            @if (\Gate::allows('create', 'community'))
            <div class="form-group">
              <label for="community_id" class="col-md-3 control-label">@lang('admin/users.community')</label>
              <div class="col-md-8 col-lg-6">
                <select id="community_id" class="form-control" name="community_id">
                  @foreach ($communities as $community)
                  <option value="{{ $community->id }}" {{ old("community_id", $filter['community']) == $community->id ? 'selected' : ''}}>
                  {{ $community->city->region->name }},
                  &nbsp;{{ $community->city->name }},
                  &nbsp;{{ $community->name }},
                  &nbsp;{{ $community->number }}</option>
                  @endforeach
                </select>
                @if ($errors->has('community_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('community_id') }}</strong>
                </span>
                @endif
              </div>
            </div>
            @else
              <input type="hidden" name="community_id" value="{{ $filter['community'] }}">
            @endif

            <div class="form-group {{ $errors->has('file_teachers') ? ' has-error' : '' }}">
              <label for="file_teachers" class="col-md-3 control-label">@lang('admin/users.select_file_upload')</label>
              <div class="col-md-8 col-lg-6">
                <input id="file_teachers" type="file" name="file_teachers">
                @if ($errors->has('file_teachers'))
                <span class="help-block">
                  <strong>{{ $errors->first('file_teachers') }}</strong>
                </span>
                @endif
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-9 col-md-offset-3">
                <button id="submit_upload" type="submit" class="btn btn-primary">@lang('admin/users.upload')</button>
              </div>
            </div>
          </form>
        </div> <!-- end <div class="panel-body"> -->
      </div> <!-- end <div class="panel panel-default"> -->
    </div> <!-- end <div class="col-md-9">-->
  </div> <!-- end <div class="row">-->
</div> <!-- end <div class="container-fluid">-->

<script>
(function($){
$(function(){

$('#submit_upload').click(function(event) {
  event.preventDefault();
  $('.container-fluid').css('opacity', '.2');

  $('#app').append('<div class="load-animation"><div class="ball"></div><div class="ball1"></div></div>');

  $('form').submit();

});

});
})(jQuery);  
</script>
@endsection