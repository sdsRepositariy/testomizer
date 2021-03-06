<div class="app-header clearfix">
	@if($folder->exists)
		@if(empty($folder->parent))
		<a class="btn btn-app-icon-primary btn-app-round-icon" href="{{ url('tasks') }}" data-current-folder="{{ $folder->id }}">
		@else
		<a class="btn btn-app-icon-primary btn-app-round-icon" href="{{ url($folderPath, [$folder->parent->id, $folderPrimaryAction]) }}" data-current-folder="{{ $folder->id }}">
		@endif
			<span class="glyphicon glyphicon-menu-left"></span>
		</a>
		<div class="app-header-text">{{ $folder->name }}</div>
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

@if($folders->isNotEmpty() || $items->isNotEmpty())
<div class="panel panel-default app-panel">
	@include('components.single_line_list')
</div>
@endif

<script>
	$("#app_modal .modal-body").viewModalList();
</script>
