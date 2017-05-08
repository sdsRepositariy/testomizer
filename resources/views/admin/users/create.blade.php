@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('admin.sidebar')
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                  <div class='row'>

                  <div class="col-sm-4 col-xs-12">
                      <div class="pull-left">
                        <p>
                          @if($user->exists === true)
                          {{ 'User: '.$user->login }}
                          @else 
                          {{ 'Fill up user data' }}
                          @endif
                        </p>
                      </div>
                    </div>

                    <div class="col-sm-6 col-xs-12">
                      @if($user->exists === true)
                      <div class="btn-group">
                        <a class="btn btn-default" href="{{url('/users/'.$user->id.'/edit')}}">Edit account</a>
                      </div> 
                      <div class="btn-group">
                        <a class="btn btn-default" href="#">Change password</a>
                      </div> 
                      @endif
                    </div>

                    <div class="col-sm-2 hidden-xs">
                      <a class="close" href="{{ url('/users') }}">Exit</a>
                    </div>
                  </div>

                </div>

                <div class="panel-body">

                    @if($user->exists === true)
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/users', $user->id) }}">
                    {{ method_field('PUT') }}
                    @else
                    <form class="form-horizontal" method="POST" action="{{ url('/users')}}">
                    {{ method_field('POST') }}
                    @endif
                    {{ csrf_field() }}

                    <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                       <label for="first_name" class="col-md-4 control-label">First name</label>

                       <div class="col-md-6">
                           <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name', $user->first_name) }}" required autofocus {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>

                           @if ($errors->has('first_name'))
                           <span class="help-block">
                               <strong>{{ $errors->first('first_name') }}</strong>
                           </span>
                           @endif
                       </div>
                   </div>

                   <div class="form-group {{ $errors->has('middle_name') ? ' has-error' : '' }}">
                       <label for="middle_name" class="col-md-4 control-label">Middle name</label>

                       <div class="col-md-6">
                           <input id="middle_name" type="text" class="form-control" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}" required {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>

                           @if ($errors->has('middle_name'))
                           <span class="help-block">
                               <strong>{{ $errors->first('middle_name') }}</strong>
                           </span>
                           @endif
                       </div>
                   </div>

                   <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                       <label for="last_name" class="col-md-4 control-label">Last name</label>

                       <div class="col-md-6">
                           <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name', $user->last_name) }}" required {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>

                           @if ($errors->has('last_name'))
                           <span class="help-block">
                               <strong>{{ $errors->first('last_name') }}</strong>
                           </span>
                           @endif
                       </div>
                   </div>

                   <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                       <label for="email" class="col-md-4 control-label">Email</label>

                       <div class="col-md-6">
                           <input id="email" type="email" class="form-control" name="email" required value="{{ old('email', $user->admin->email) }}" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>

                           @if ($errors->has('email'))
                           <span class="help-block">
                               <strong>{{ $errors->first('email') }}</strong>
                           </span>
                           @endif
                       </div>
                   </div>

                   <div class="form-group {{ $errors->has('phone_number') ? ' has-error' : '' }}">
                       <label for="phone_number" class="col-md-4 control-label">Phone number</label>

                       <div class="col-md-6">
                           <input id="phone_number" type="number" class="form-control" name="phone_number" value="{{ old('phone_number', $user->admin->phone_number) }}" required {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>

                           @if ($errors->has('phone_number'))
                           <span class="help-block">
                               <strong>{{ $errors->first('phone_number') }}</strong>
                           </span>
                           @endif
                       </div>
                   </div>

                   <div class="form-group {{ $errors->has('birthday') ? ' has-error' : '' }}">
                       <label for="city" class="col-md-4 control-label">Birthday</label>

                       <div class="col-md-6">
                           <input id="birthday" type="date" class="form-control" name="date" value="{{ old('birthdate', $user->birthday) }}" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>

                           @if ($errors->has('birthday'))
                           <span class="help-block">
                               <strong>{{ $errors->first('birthday') }}</strong>
                           </span>
                           @endif
                       </div>
                   </div>

                   <div class="form-group {{ $errors->has('position') ? ' has-error' : '' }}">
                       <label for="position" class="col-md-4 control-label">Position</label>

                       <div class="col-md-6">
                           <input id="position" type="text" class="form-control" name="position" value="{{ old('position', $user->admin->position) }}" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>

                           @if ($errors->has('position'))
                           <span class="help-block">
                               <strong>{{ $errors->first('position') }}</strong>
                           </span>
                           @endif
                       </div>
                   </div>

                   @if(Request::is('*/edit')||Request::is('*/create'))
                   <div class="form-group">
                      <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                   </div>
                   @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection