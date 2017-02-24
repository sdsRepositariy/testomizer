<div class="list-group">
  <a href="{{ url('/users') }}" class="list-group-item {{\Request::is('users*') ? 'active' : ''}}">
    User manager
  </a>
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