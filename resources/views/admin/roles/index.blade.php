@extends('layouts.app')

@section('content')
<div class="container-fluid full-height">
    <div class="row">
        <div class="col-xs-12">
        	<div class="panel panel-default">
        		<!-- Nav tabs -->
        		<ul class="nav nav-pills nav-justified">
        			@foreach ($roles as $role)
        			<li class="{{\Request::is('settings/permissions/'.$role->role) ? 'active' : ''}}">
        				<a href="{{ url('settings/permissions/'.$role->role) }}" class="text-capitalize">{{ $role->role }}</a>
        			</li>
        			@endforeach
        		</ul>
        		<div class="panel-heading">
        		  <h4>The set of permissions for role: <span class="text-capitalize">"{{ $currentRole->role }}"</span></h4>
        		</div>
          
        		<form method="POST" action="{{ url('settings/permissions', $currentRole->role) }}">
                    {{ csrf_field() }}
        			<div class="table-responsive">
        				<table class="table table-striped">
        					<thead>
        						<tr>
        							<th>Objects</th>
        							@foreach ($permissions as $permission)
        							<th class="text-capitalize">{{ $permission->name }}</th>
        							@endforeach
        						</tr>
        					</thead>
        					<tbody>
        						@foreach ($objects as $object)
        						<tr>
        							<td>
                                        <span class="text-capitalize">
                                            {{ $object->slug }}
                                        </span>
                                    </td>
        							@foreach ($permissions as $permission)
        							<td>
                                        @php
                                        $allow = $permission->roles()->where('object_id', $object->id)->where('role_id', $currentRole->id)->get()->isNotEmpty();
                                        @endphp
        								<input type="checkbox" value="{{ $permission->id }}" {{ ($allow)? 'checked' : "" }} name="{{ $object->id.'-'.$permission->id }}">
        							</td>
        							@endforeach
        						</tr>
        						@endforeach
        					</tbody>
        				</table>
        			</div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
        		</form>
        	</div>
        </div>
    </div>
    @if ( \Session::has('flash_message') )
        <div class="snackbar-toggle" data-snackbar-type="success">{{ \Session::get('flash_message') }}</div>
    @elseif (\Session::has('flash_error_message'))
        <div class="snackbar-toggle" data-snackbar-type="error">{{ \Session::get('flash_error_message') }}</div>
    @endif
</div>

@endsection