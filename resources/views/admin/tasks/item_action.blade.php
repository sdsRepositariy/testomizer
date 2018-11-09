<div class="list-secondary-action dropdown">
	<button class="btn btn-app-round-icon btn-app-icon-default dropdown-toggle" type="button" data-toggle="dropdown">
		<span class="glyphicon glyphicon-option-vertical"></span>
	</button>
	<ul class="dropdown-menu dropdown-menu-right">
		<li>
			<a href="{{ url($itemPath, $item->id) }}" data-modal-title="@lang('admin/tasks.view_task')">
				<span class="glyphicon glyphicon-info-sign"></span>
				<div>@lang('common.info')</div>
			</a>
		</li>
		<li>
			<a href="#">
				<span class="glyphicon glyphicon-ok-circle"></span>
				<div>Run task</div>
			</a>
		</li>
		<li>
			<a href="{{ url($itemPath, [$item->id, 'edit']) }}" data-modal-title="@lang('admin/tasks.edit_task')">
				<span class="glyphicon glyphicon-edit"></span>
				<div>@lang('common.edit')</div>
			</a>
		</li>
		<li>
			<a href="{{ url($itemPath, [$item->id, 'move']) }}" data-modal-title="@lang('admin/tasks.move_task')">
				<span class="glyphicon glyphicon-transfer"></span>
				<div>@lang('common.move')</div>
			</a>
		</li>
		<li>
			<a href="{{ url($itemPath, [$item->id, 'delete']) }}" data-modal-title="@lang('admin/tasks.delete_task')">
				<span class="glyphicon glyphicon-trash"></span>
				<div>@lang('common.delete')</div>
			</a>
		</li>
	</ul>
</div>