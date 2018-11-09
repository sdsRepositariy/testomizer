@extends('components.modal')

@section('body')

@if($data->exists === true)
<form class="form-horizontal" method="POST" action="{{ $action }}">
{{ method_field('PUT') }}
@else
<form class="form-horizontal" method="POST" action="{{ $action }}">
{{ method_field('POST') }}
@endif
{{ csrf_field() }}
	<div class="form-group">
		<label for="task_group_name" class="col-sm-2 control-label">Name</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="task_group_name" placeholder="Name" name="name" value="{{ old('name', $data->name) }}" maxlength="64" autofocus required {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'readonly' }}>
		</div>
	</div>
	<div class="form-group">
		<label for="task_group_description" class="col-sm-2 control-label">Description</label>
		<div class="col-sm-10">
			<textarea class="form-control" id="task_group_description" name="description" placeholder="Description" maxlength="255" {{ (Request::is('*/edit')||Request::is('*/create')) ? '' : 'readonly' }}>{{ old('description', $data->description) }}</textarea>
		</div>
	</div>
	<input id="parent_folder" type="text" name="parent_folder" value="{{ isset($parentFolder) ? $parentFolder : '' }}" hidden>
	<input id="submit_form_hidden" type="submit" hidden>
</form>
@endsection