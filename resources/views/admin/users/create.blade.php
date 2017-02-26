@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('admin.sidebar')
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if($user->exists === true)
                    {{'Update the user data'}}
                    @else
                    {{'Fill up user data'}}
                    @endif
                </div>

                <div class="panel-body">

                    @if($user->exists === true)
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/users', $user->id) }}">
                    {{method_field('PUT')}}
                    @else
                    <form class="form-horizontal" method="POST" action="{{ url('/users')}}">
                    {{method_field('POST')}}
                    @endif
                    {{ csrf_field() }}

                    <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                       <label for="first_name" class="col-md-4 control-label">First name</label>

                       <div class="col-md-6">
                           <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name', $user->first_name) }}" required autofocus>

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
                           <input id="middle_name" type="text" class="form-control" name="middle_name" value="{{ old('middle_name', $user->middle_name) }}" required>

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
                           <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>

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
                           <input id="email" type="email" class="form-control" name="email" required value="{{ old('email', $user->email) }}">

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
                           <input id="phone_number" type="number" class="form-control" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required>

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
                           <input id="country" type="text" class="form-control" name="country" value="{{ old('country', $user->country) }}">

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
                           <input id="city" type="text" class="form-control" name="city" value="{{ old('city', $user->city) }}">

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
                           <input id="school_number" type="number" class="form-control" name="school_number" value="{{ old('school_number', $user->school_number) }}">

                           @if ($errors->has('school_number'))
                           <span class="help-block">
                               <strong>{{ $errors->first('school_number') }}</strong>
                           </span>
                           @endif
                       </div>
                   </div>

                   <div class="form-group {{ $errors->has('role_id') ? ' has-error' : '' }}">
                       <label for="role_id" class="col-md-4 control-label">User role</label>

                       <div class="col-md-6">
                           <select id="role_id" class="form-control" name="role_id">
                           @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ ($role->role == 'user') ? ' selected' : '' }}>{{ $role->role }}</option>
                           @endforeach
                           </select> 

                           @if ($errors->has('role_id'))
                           <span class="help-block">
                               <strong>{{ $errors->first('role_id') }}</strong>
                           </span>
                           @endif
                       </div>
                   </div>
                   
                   <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                       <label for="password" class="col-md-4 control-label">Password</label>

                       <div class="col-md-6">
                           <input id="password" type="text" class="form-control" name="password" value="{{ old('password', $user->password) }}" required>

                           @if ($errors->has('password'))
                           <span class="help-block">
                               <strong>{{ $errors->first('password') }}</strong>
                           </span>
                           @endif
                       </div>
                   </div>

                   <div class="form-group">
                       <div class="col-md-8 col-md-offset-4">
                           <button type="submit" class="btn btn-primary">

                               @if($user->exists === true)
                               {{'Update'}}
                               @else
                               {{'Save'}}
                               @endif

                           </button>
                       </div>
                   </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection