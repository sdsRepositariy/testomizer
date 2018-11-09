<div class="list-group">

  <a href="#users" data-toggle="collapse" class="list-group-item">User manager</a>
  <div id="users" class="{{\Request::is('*usergroup*') ? 'collapse in' : 'collapse'}}">
    @foreach(App\Models\Users\UserGroup::all() as $usergroup)
    <a href="{{ url('usergroup/'.$usergroup->group.'/list') }}" class="list-group-item clearfix {{\Request::is('*'.$usergroup->group.'*') ? 'active' : ''}}">
      <span class ="text-capitalize pull-right">{{ $usergroup->group }}</span>
    </a>
    @endforeach
  </div>

   <a href="#tasks" data-toggle="collapse" class="list-group-item">Task manager</a>
  <div id="tasks" class="{{\Request::is('*tasks*') ? 'collapse in' : 'collapse'}}">
    <a href="{{ url('tasks') }}" class="list-group-item clearfix {{\Request::is('*tasks*') ? 'active' : ''}}">
      <span class ="pull-right">Tasks list</span>
    </a>
    <a href="{{ url('tasks/new') }}" class="list-group-item clearfix">
      <span class ="pull-right">New tasks</span>
    </a>
    <a href="{{ url('tasks/completed') }}" class="list-group-item clearfix">
      <span class ="pull-right">Completed tasks</span>
    </a>
  </div>

  <a href="#tests" data-toggle="collapse" class="list-group-item">Test manager</a>
  <div id="tests" class="{{\Request::is('*tests*') ? 'collapse in' : 'collapse'}}">
  	<a href="{{ url('tests') }}" class="list-group-item clearfix">
  		<span class ="pull-right">Test lists</span>
  	</a>
    <a href="#" class="list-group-item clearfix">
      <span class ="pull-right">Create test</span>
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

