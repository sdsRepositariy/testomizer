<div class="list-group">
  @can('create', App\Models\Users\Admin::class)
    <a href="{{ url('/admin') }}" class="list-group-item {{\Request::is('admin*') ? 'active' : ''}}">
    User manager
    </a>
  @endcan
  <a href="#test" data-toggle="collapse" class="list-group-item">Test manager</a>
  <div id="test" class="collapsing">
  	<a href="#" class="list-group-item clearfix">
  		<span class ="pull-right">Create test</span>
  	</a>
  	<a href="#" class="list-group-item clearfix">
  		<span class ="pull-right">Test lists</span>
  	</a>
  </div>
  <a href="#" class="list-group-item">Account manager</a>
  <a href="#" class="list-group-item">Respondent manager</a>
  <a href="#" class="list-group-item">Settings</a>
</div>