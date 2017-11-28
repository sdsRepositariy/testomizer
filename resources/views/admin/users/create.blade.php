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
                  @elseif($usergroup->group == 'parents') 
                  {{ 'Fill up parent data for student: '.$student->last_name.'&nbsp;'.$student->first_name }}
                  @else
                  {{ 'Fill up user data' }}
                  @endif
                </p>
              </div>
            </div>

            <div class="col-sm-6 col-xs-12">
              @if($user->exists === true)
              <div class="btn-group">
                <a class="btn btn-default" href="{{url($slug, $user->id.'/edit')}}">Edit account</a>
              </div> 
              <div class="btn-group">
                <a class="btn btn-default" href="#">Change password</a>
              </div> 
              @endif
            </div>

            <div class="col-sm-2 hidden-xs">
              <a class="close" href="{{ url($slug) }}">Exit</a>
            </div>
          </div>

        </div>

        <div class="panel-body">

          @if($user->exists === true)
          <form class="form-horizontal" method="POST" action="{{ url($slug, $user->id) }}">
          {{ method_field('PUT') }}
          @else
          <form class="form-horizontal" method="POST" action="{{ url($slug) }}">
          {{ method_field('POST') }}
          @endif
          {{ csrf_field() }}
            
            @if($usergroup->group == 'parents')
            <input type="hidden" name="user_id" value="{{ $student->id }}">
            @endif

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
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>

                @if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                <div class="form-group {{ $errors->has('phone_number') ? ' has-error' : '' }}">
                  <label for="phone_number" class="col-md-8 control-label">Phone number</label>
                  <div class="col-md-4">
                    <input id="phone_number" type="number" class="form-control" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>

                    @if ($errors->has('phone_number'))
                    <span class="help-block">
                      <strong>{{ $errors->first('phone_number') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="form-group {{ $errors->has('birthday') ? ' has-error' : '' }}">
                  <label for="city" class="col-md-4 control-label">Birthday</label>
                  <div class="col-md-4">
                    <input id="birthday" type="date" class="form-control" name="birthday" placeholder="YYYY-MM-DD" value="{{ old('birthdate', $user->birthday) }}" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>

                    @if ($errors->has('birthday'))
                    <span class="help-block">
                      <strong>{{ $errors->first('birthday') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
              </div>
            </div>

            @if (\Gate::allows('create', 'community'))
            <div class="form-group {{ $errors->has('community_id') ? ' has-error' : '' }}">
              <label for="community_id" class="col-md-4 control-label">Community</label>
              <div class="col-md-6">
                <select id="community_id" class="form-control" name="community_id" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>
                  @foreach ($communities as $community)
                  <option value="{{ $community->id }}" {{ old('community_id') == $community->id ? 'selected' : ''}}>
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
            @endif

            @if($usergroup->group == 'teachers')
            <div class="form-group {{ $errors->has('role_id') ? ' has-error' : '' }}">
              <label for="role_id" class="col-md-4 control-label">Role</label>
              <div class="col-md-3">
                <select id="role_id" class="form-control" name="role_id" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>
                  @foreach ($roles as $id => $role)
                  <option value='{{ $id }}' {{ old('role_id') == $id ? 'selected' : ''}}>
                    {{ $role }}
                 </option>
                  @endforeach
                </select>
                
                @if ($errors->has('role_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('role_id') }}</strong>
                </span>
                @endif
              </div>
            </div>
            @endif

            @if($usergroup->group == 'students')
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group {{ $errors->has('level_id') ? ' has-error' : '' }}">
                  <label for="level_id" class="col-md-8 control-label">Level</label>
                  <div class="col-md-4">
                    <select id="level_id" class="form-control" name="level_id" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>
                    @foreach ($levels as $level)
                      <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : ''}}>
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

              <div class="col-sm-6">
                <div class="form-group {{ $errors->has('stream_id') ? ' has-error' : '' }}">
                  <label for="stream_id" class="col-md-4 control-label">Stream</label>
                  <div class="col-md-4">
                    <select id="stream_id" class="form-control" name="stream_id" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>
                    @foreach ($streams as $stream)
                      <option value="{{ $stream->id }}" {{ old('stream_id') == $stream->id ? 'selected' : ''}}>
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
            
            <div class="form-group {{ $errors->has('period_id') ? ' has-error' : '' }}">
              <label for="period" class="col-md-4 control-label">Academic year</label>
              <div class="col-md-3">
                <select id="period_id" class="form-control" name="period_id" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'disabled' }}>
                    @foreach ($periods as $period)
                      <option value="{{ $period->id }}" {{ old('period_id') == $period->id ? 'selected' : ''}}>
                      {{ $period->period() }}
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
            @endif

            @if(Request::is('*/edit')||Request::is('*/create'))
            <div class="form-group">
              <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div>
            @endif

          </form>

        </div> <!-- end <div class="panel-body"> -->
      </div> <!-- end <div class="panel panel-default"> -->
    </div> <!-- end <div class="col-md-9">-->
  </div> <!-- end <div class="row">-->
</div> <!-- end <div class="container-fluid">-->
@endsection