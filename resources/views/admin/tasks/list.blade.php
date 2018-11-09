@extends('layouts.app')

@section('content')
<div class="container-fluid full-height">
	<!-- Group list -->
	<div>
		<div class="app-header clearfix">
			@if($folder->exists)
				@if(empty($folder->parent))
				<a class="btn btn-app-icon-primary btn-app-round-icon" href="{{ url('tasks') }}">
				@else
				<a class="btn btn-app-icon-primary btn-app-round-icon" href="{{ url($folderPath, $folder->parent->id).'/list' }}">
				@endif
					<span class="glyphicon glyphicon-menu-left"></span>
				</a>
				<div class="app-header-text">{{ $folder->name }}</div>
			@else
				<div class="app-header-text">@lang('admin/tasks.task_list')</div>
			@endif			
		</div>
		<div class="subheader clearfix">
			<div class="row">
				<div class="col-xs-6 hidden-lg hidden-md">
					@if($folders->isNotEmpty())
					<div class="text-muted pull-left">@lang('admin/tasks.groups')</div>
					@else
					<div class="text-muted pull-left">@lang('admin/tasks.tasks')</div>
					@endif
				</div>
				<div class="col-xs-6">
					@component('components.sortlink')
						@slot('url')
				    		{{ $sortData["name"]["url"] }}
						@endslot

						@slot('sorted')
				    		{{ $sortData["name"]["sorted"] }}
						@endslot

						@slot('sortBy')
							@lang('admin/tasks.by_name')
						@endslot
					@endcomponent
				</div>
			</div>
		</div>
	</div>
	<div class="app-panel-wrapper">
		<div class="panel panel-default app-panel">
			@include('components.single_line_list')
		</div>
	</div>
	<!-- End of group list -->
	@if ( \Session::has('flash_success_message') )
	<div class="snackbar-toggle" data-snackbar-type="success">{{ \Session::get('flash_success_message') }}</div>
	@elseif (\Session::has('flash_error_message'))
	<div class="snackbar-toggle" data-snackbar-type="error">{{ \Session::get('flash_error_message') }}</div>
	@endif
</div>
<script>
	//Run handler
	$(function(){
		$('.list-secondary-action').listActionModalLoader();
	});
</script>
@endsection