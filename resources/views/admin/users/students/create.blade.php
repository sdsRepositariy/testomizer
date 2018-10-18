@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12">
      @if ( \Session::has('flash_message') )
      <div class="alert alert-success alert-dismissable">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        {{ \Session::get('flash_message') }}
      </div>
      @endif
      @if ( $errors->has('student_error') )
      <div class="alert alert-danger alert-dismissable">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        {{ $errors->first('student_error') }}
      </div>
      @endif 
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class='row'>

            <div class="col-sm-4 col-xs-12">
              <div class="text-left">
                <h4>
                  @if($user->exists === true)
                    @if (Request::is('*/edit'))
                      @lang('admin/users.edit_user')
                    @else
                      @lang('admin/users.view_user')
                    @endif
                  @else
                    @lang('admin/users.create_user')
                  @endif
                </h4>
              </div>
            </div>

            <div class="col-sm-6 col-xs-12 col-md-5">
              <div class="text-right">
                @if($user->exists === true)
                <div class="btn-group">
                  <a class="btn btn-default" href="{{url($path, $user->id).'/edit' }}">@lang('admin/users.edit_account')</a>
                </div> 
                <div class="btn-group">
                  <a class="btn btn-default" href="{{url($path, $user->id).'/changepassword' }}">@lang('admin/users.change_password')</a>
                </div> 
                @endif
              </div>
            </div>

            <div class="col-sm-2 col-md-offset-1 hidden-xs">
              <a class="close" href="{{ $urlUserList }}">@lang('admin/users.exit')</a>
            </div>
          </div>

        </div>

        <div class="panel-body">

          @if($user->exists === true)
          <form class="form-horizontal" method="POST" action="{{ url($path, $user->id) }}">
          {{ method_field('PUT') }}
          @else
          <form class="form-horizontal" method="POST" action="{{ url($path) }}">
          {{ method_field('POST') }}
          @endif
          {{ csrf_field() }}
            
            @if (\Gate::allows('create', 'community'))
            <div class="form-group {{ $errors->has('community_id') ? ' has-error' : '' }}">
              <label for="community_id" class="col-md-3 control-label">@lang('admin/users.community')</label>
              <div class="col-md-8 col-lg-6">
                <select id="community_id" class="form-control" name="community_id" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>
                  @foreach ($communities as $community)
                  <option value="{{ $community->id }}" {{ $filter['community'] == $community->id ? 'selected' : ''}}>
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

            <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
              <label for="first_name" class="col-md-3 control-label">@lang('admin/users.first_name')</label>
              <div class="col-md-8 col-lg-6">
                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name', $user->first_name) }}" required autofocus {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'readonly' }}>

                @if ($errors->has('first_name'))
                <span class="help-block">
                  <strong>{{ $errors->first('first_name') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group {{ $errors->has('middle_name') ? ' has-error' : '' }}">
              <label for="middle_name" class="col-md-3 control-label">@lang('admin/users.middle_name')</label>
              <div class="col-md-8 col-lg-6">
                <input id="middle_name" type="text" class="form-control" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}" required {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'readonly' }}>

                @if ($errors->has('middle_name'))
                <span class="help-block">
                  <strong>{{ $errors->first('middle_name') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
              <label for="last_name" class="col-md-3 control-label">@lang('admin/users.last_name')</label>
              <div class="col-md-8 col-lg-6">
                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name', $user->last_name) }}" required {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'readonly' }}>

                @if ($errors->has('last_name'))
                <span class="help-block">
                  <strong>{{ $errors->first('last_name') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email" class="col-md-3 control-label">@lang('admin/users.email')</label>
              <div class="col-md-8 col-lg-6">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'readonly' }}>

                @if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
              </div>
            </div>
              
            <div class="form-group {{ $errors->has('phone_number') ? ' has-error' : '' }}">
              <label for="phone_number" class="col-md-3 col-lg-3 control-label">@lang('admin/users.phone_number')</label>
              <div class="col-md-4 col-lg-3">
                <input id="phone_number" type="text" class="form-control" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'readonly' }}>

                @if ($errors->has('phone_number'))
                <span class="help-block">
                  <strong>{{ $errors->first('phone_number') }}</strong>
                </span>
                @endif
              </div>
            </div>
            
            <div class="form-group {{ $errors->has('birthday') ? ' has-error' : '' }}">
              <label for="birthday" class="col-md-3 col-lg-3 control-label">@lang('admin/users.birthday')</label>
              <div class="col-md-4 col-lg-3">
                <input id="birthday" type="date" class="form-control" name="birthday" value="{{ old('birthday', $user->birthday) }}" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'readonly' }} required>

                @if ($errors->has('birthday'))
                <span class="help-block">
                  <strong>{{ $errors->first('birthday') }}</strong>
                </span>
                @endif
              </div>
            </div>
                    
            <div class="form-group {{ $errors->has('period_id') ? ' has-error' : '' }}">
              <label for="period_id" class="col-md-3 col-lg-3 control-label">@lang('admin/users.period')</label>
              <div class="col-md-4 col-lg-3">
                <select id="period_id" class="form-control" name="period_id" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>
                    @foreach ($periods as $period)
                      <option value="{{ $period->id }}" {{ $filter['period'] == $period->id ? 'selected' : ''}}>
                      {{ $period->getPeriod() }}
                      </option>
                    @endforeach
                    </select>

                @if ($errors->has('period_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('period_id') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6 col-lg-6">
                <div class="form-group {{ $errors->has('level_id') ? ' has-error' : '' }}">
                  <label for="level_id" class="col-md-6 col-lg-6 control-label">@lang('admin/users.level')</label>
                  <div class="col-md-6 col-lg-4">
                    <select id="level_id" class="form-control" name="level_id" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>
                    @foreach ($levels as $level)
                      <option value="{{ $level->id }}" {{ $filter['level'] == $level->id ? 'selected' : ''}}>
                      {{ $level->number }}
                      </option>
                    @endforeach
                    </select>
                    
                    @if ($errors->has('level_id'))
                    <span class="help-block">
                      <strong>{{ $errors->first('level_id') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
              </div>
    
              <div class="col-sm-6 col-lg-6">
                <div class="form-group {{ $errors->has('stream_id') ? ' has-error' : '' }}">
                  <label for="stream_id" class="col-lg-2 col-md-4 control-label">@lang('admin/users.stream')</label>
                  <div class="col-lg-4 col-md-6">
                    <select id="stream_id" class="form-control" name="stream_id" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>
                    @foreach ($streams as $stream)
                      <option value="{{ $stream->id }}" {{ $filter['stream'] == $stream->id ? 'selected' : ''}}>
                      {{ $stream->name }}
                      </option>
                    @endforeach
                    </select>

                    @if ($errors->has('stream_id'))
                    <span class="help-block">
                      <strong>{{ $errors->first('stream_id') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            
            @if($user->exists === true && !Request::is('*/edit'))
            <div class="row">
              <div class="col-sm-6 col-md-12">
                <div class="form-group">
                  <label for="login" class="col-md-3 control-label">@lang('admin/users.login')</label>
                  <div class="col-md-4 col-lg-3">
                    <input id="login" type="text" class="form-control" value="{{ $user->login }}" readonly>
                  </div>
                </div>
              </div>
            
              <div class="col-sm-6 col-md-12">
                <div class="form-group">
                  <label for="password" class="col-md-3 control-label">@lang('admin/users.password')</label>
                  <div class="col-md-4 col-lg-3">
                    <input id="password" type="text" class="form-control" value="{{ $user->password }}" readonly>
                  </div>
                </div>
              </div>
            </div>
            @endif

            @if(Request::is('*/edit')||Request::is('*/create'))
            <div class="row">
              <div class="col-md-9 col-md-offset-3">
                <button type="submit" class="btn btn-primary">@lang('admin/users.save')</button>
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

//Add required mark
var required = $("[required]").parent().prev().append('<span>*</span>').find('span').addClass('required-mark');

$("input:not([required]), select").parent().prev().append('&nbsp;');

});
})(jQuery);  
</script>

@endsection