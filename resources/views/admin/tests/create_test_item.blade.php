@extends('layouts.app')

@section('content')
<div class="container-fluid full-height">
	<div class="app-header clearfix">
		<div class="app-header-text">@lang('admin/tests.create_test')</div>
	</div>
	<div class="subheader app-tabs">
		<ul class="nav nav-tabs">
			<li role="presentation" class="active"><a href="#title" data-toggle="tab">@lang('admin/tests.title')</a></li>
			<li role="presentation"><a href="#scales" data-toggle="tab">@lang('admin/tests.scales')</a></li>
			<li role="presentation"><a href="#questions" data-toggle="tab">@lang('admin/tests.questions')</a></li>
			<li role="presentation"><a href="#">@lang('admin/tests.interpretations')</a></li>
		</ul>
	</div>	
	<div class="app-panel-wrapper">
		<div class="panel panel-default app-panel for-tabs">
			<div class="panel-body">
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="title">
						@include('admin/tests/title_tab')
					</div>
					<div role="tabpanel" class="tab-pane" id="scales">
						@include('admin/tests/scale_tab')
					</div>
					<div role="tabpanel" class="tab-pane" id="questions">
						@include('admin/tests/question_tab')
					</div>
					<div role="tabpanel" class="tab-pane" id="interpretations">...</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection