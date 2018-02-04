<div class="list-group">

  <a href="#users" data-toggle="collapse" class="list-group-item">User manager</a>
  <div id="users" class="{{\Request::is('*usergroup*') ? 'collapse in' : 'collapse'}}">
    @foreach(App\Models\Users\UserGroup::all() as $usergroup)
    <a href="{{ url('usergroup/'.$usergroup->group.'/list') }}" class="list-group-item clearfix {{\Request::is('*'.$usergroup->group.'*') ? 'active' : ''}}">
      <span class ="text-capitalize pull-right">{{ $usergroup->group }}</span>
    </a>
    @endforeach
  </div>

  <a href="#test" data-toggle="collapse" class="list-group-item">Test manager</a>
  <div id="test" class="collapse">
  	<a href="#" class="list-group-item clearfix">
  		<span class ="pull-right">Create test</span>
  	</a>
  	<a href="#" class="list-group-item clearfix">
  		<span class ="pull-right">Test lists</span>
  	</a>
  </div>
  <a href="#settings" data-toggle="collapse" class="list-group-item">Settings</a>
  <div id="settings" class="{{\Request::is('*settings*') ? 'collapse in' : 'collapse'}}">
    <a href="{{ url('settings/permissions/superadmin') }}" class="list-group-item clearfix {{\Request::is('settings/permissions*') ? 'active' : ''}}">
      <span class ="pull-right">Permissions</span>
    </a>
    <a href="{{ url('settings/communities') }}" class="list-group-item clearfix {{\Request::is('settings/communities*') ? 'active' : ''}}">
      <span class ="pull-right">Communities</span>
    </a>
    <a href="#" class="list-group-item clearfix">
      <span class ="pull-right">Email</span>
    </a>
  </div>
</div>