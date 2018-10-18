@extends('components.modal')

@section('form')

<form method="POST" action="{{ $action }}">
	{{ method_field('DELETE') }}
	<h4 class="app-form-info">@lang('common.delete_it', ['name' => $name])</h4>
</form>

@endsection