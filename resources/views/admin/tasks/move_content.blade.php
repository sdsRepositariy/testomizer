<div class="app-header clearfix">
	@if($taskFolder->exists)
		@if(empty($taskFolder->task_folder_id))
		<a class="btn btn-app-icon-primary btn-app-round-icon" href="{{ url('tasks') }}">
		@else
		<a class="btn btn-app-icon-primary btn-app-round-icon" href="{{ url($folderPath, $taskFolder->task_folder_id).'/list' }}">
		@endif
			<span class="glyphicon glyphicon-menu-left"></span>
		</a>
		<div class="app-header-text">{{ $taskFolder->name }}</div>
	@else
		<div class="app-header-text">@lang('admin/tasks.task_list')</div>
	@endif			
</div>

<div class="subheader hidden-lg hidden-md clearfix">
	<div class="row">
		<div class="col-xs-12">
			@if($folders->isNotEmpty())
			<div class="text-muted pull-left">@lang('admin/tasks.groups')</div>
			@else
			<div class="text-muted pull-left">@lang('admin/tasks.tasks')</div>
			@endif
		</div>
	</div>
</div>

<div class="panel panel-default app-panel">
	@include('components.single_line_list')
</div>
