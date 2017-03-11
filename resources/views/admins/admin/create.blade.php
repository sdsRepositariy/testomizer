@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('admins.sidebar')
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                  <div class='row'>

                    <div class="col-md-6">
                      <div class="pull-left">
                        <p>
                          @if($admin->exists === true)
                            {{ 'User: '.$admin->member->login }}
                          @else 
                            {{ 'Fill up user data' }}
                          @endif
                        </p>
                      </div>
                    </div>

                    <div class="col-md-6 hidden-xs">
                      <a class="close" href="{{ url('/admin') }}">Exit</a>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 col-md-offset-4 text-left">
                      @if($admin->exists === true)
                      <div class="btn-group">
                        <a class="btn btn-default" href="{{url('/admin/'.$admin->id.'/edit')}}">Edit account</a>
                      </div> 
                      <div class="btn-group">
                        <a class="btn btn-default" href="#">Change password</a>
                      </div> 
                      @endif
                    </div>
                  </div>
                 </div>

                <div class="panel-body">

                    @if($admin->exists === true)
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin', $admin->id) }}">
                    {{ method_field('PUT') }}
                    @else
                    <form class="form-horizontal" method="POST" action="{{ url('/admin')}}">
                    {{ method_field('POST') }}
                    @endif
                    {{ csrf_field() }}

                    <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                       <label for="first_name" class="col-md-4 control-label">First name</label>

                       <div class="col-md-6">
                           <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name', $admin->first_name) }}" required autofocus {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>

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
                           <input id="middle_name" type="text" class="form-control" name="middle_name" value="{{ old('middle_name', $admin->middle_name) }}" required {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>

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
                           <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name', $admin->last_name) }}" required {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>

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
                           <input id="email" type="email" class="form-control" name="email" required value="{{ old('email', $admin->email) }}" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>

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
                           <input id="phone_number" type="number" class="form-control" name="phone_number" value="{{ old('phone_number', $admin->phone_number) }}" required {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>

                           @if ($errors->has('phone_number'))
                           <span class="help-block">
                               <strong>{{ $errors->first('phone_number') }}</strong>
                           </span>
                           @endif
                       </div>
                   </div>

                   <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
                       <label for="country" class="col-md-4 control-label">Country</label>

                       <div class="col-md-6">
                           <input id="country" type="text" class="form-control" name="country" value="{{ old('country', $admin->country) }}" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>

                           @if ($errors->has('country'))
                           <span class="help-block">
                               <strong>{{ $errors->first('country') }}</strong>
                           </span>
                           @endif
                       </div>
                   </div>

                   <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
                       <label for="city" class="col-md-4 control-label">City</label>

                       <div class="col-md-6">
                           <input id="city" type="text" class="form-control" name="city" value="{{ old('city', $admin->city) }}" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>

                           @if ($errors->has('city'))
                           <span class="help-block">
                               <strong>{{ $errors->first('city') }}</strong>
                           </span>
                           @endif
                       </div>
                   </div>

                   <div class="form-group {{ $errors->has('school_number') ? ' has-error' : '' }}">
                       <label for="school_number" class="col-md-4 control-label">School number</label>

                       <div class="col-md-6">
                           <input id="school_number" type="number" class="form-control" name="school_number" value="{{ old('school_number', $admin->school_number) }}" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>

                           @if ($errors->has('school_number'))
                           <span class="help-block">
                               <strong>{{ $errors->first('school_number') }}</strong>
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