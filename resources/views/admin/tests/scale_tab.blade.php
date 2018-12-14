<form class="form-horizontal">
	<table class="table app-table-collapse">
		<tr>
			<th>&#x02116;</th>
			<th>@lang('admin/tests.scale')</th>
			<th>@lang('admin/tests.scale_description')</th>
			<th>@lang('common.action')</th>
		</tr>
		<tr class="app-input-section">
			<td data-number-header="@lang('admin/tests.scale')&#x02116;&nbsp;">1</td>
			<td>
				<label for="scale_1" class="control-label visible-xs-block">@lang('admin/tests.scale')</label>
				<textarea rows="3" class="form-control" id="scale_1" placeholder="@lang('admin/tests.scale')"></textarea>
			</td>
			<td>
				<label for="scale_description_1" class="control-label visible-xs-block">@lang('admin/tests.scale_description')</label>
				<textarea rows="3" class="form-control" id="scale_description_1" placeholder="@lang('admin/tests.scale_description')"></textarea>
			</td>
			<td>
				<button type="button" class="btn btn-danger">@lang('common.delete')</button>
			</td>
		</tr>
		<tr class="app-input-section">
			<td data-number-header="@lang('admin/tests.scale')&#x02116;&nbsp;">2</td>
			<td>
				<label for="scale_2" class="control-label visible-xs-block">@lang('admin/tests.scale')</label>
				<textarea rows="3" class="form-control" id="scale_2" placeholder="@lang('admin/tests.scale')"></textarea>
			</td>
			<td>
				<label for="scale_description_2" class="control-label visible-xs-block">@lang('admin/tests.scale_description')</label>
				<textarea rows="3" class="form-control" id="scale_description_2" placeholder="@lang('admin/tests.scale_description')"></textarea>
			</td>
			<td>
				<button type="button" class="btn btn-danger">@lang('common.delete')</button>
			</td>
		</tr>
		<tr>
			<td colspan="4">
				<button id="addScale" type="button" class="btn btn-primary">@lang('common.add')</button>
			</td>
		</tr>
	</table>
</form>









<!-- <form class="form-horizontal">
	<div class="form-group">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading hidden-xs">
					<div class="row">
						<div class="col-sm-5">
							<strong>@lang('admin/tests.scale')</strong>
						</div>
						<div class="col-sm-5">
							<strong>@lang('admin/tests.scale_description')</strong>
						</div>
					</div>
				</div>
				<ul class="list-group">
					<li class="list-group-item app-form-list">
						<div class="row">
							<div class="col-xs-12 col-sm-2 col-sm-push-10">
								<button data-delete-scale="1" type="button" class="btn btn-danger pull-right btn-xs visible-xs-block"><span class="glyphicon glyphicon-remove"></span></button>
								<button data-delete-scale="1" type="button" class="btn btn-danger pull-right hidden-xs">@lang('common.delete')</button>
							</div>
							<div class="col-xs-12 col-sm-5 col-sm-pull-2">
								<label for="scale_1" class="control-label visible-xs-block">@lang('admin/tests.scale')
								</label>
								<textarea rows="3" class="form-control" id="scale_1" placeholder="@lang('admin/tests.scale')"></textarea>
							</div>
							<div class="col-xs-12 col-sm-5 col-sm-pull-2">
								<label for="scale_description_1" class="control-label visible-xs-block">@lang('admin/tests.scale_description')</label>
								<textarea rows="3" class="form-control" id="scale_description_1" placeholder="@lang('admin/tests.scale_description')"></textarea>
							</div>
						</div>
					</li>
				</ul>
				<div class="panel-footer clearfix">
					<button id="addScale" type="button" class="btn btn-primary pull-left">@lang('common.add')</button>
				</div>
			</div>
		</div>
	</div>
</form> -->