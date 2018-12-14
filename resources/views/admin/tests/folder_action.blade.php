<div class="list-secondary-action dropdown">
	<button class="btn btn-app-round-icon btn-app-icon-default dropdown-toggle" type="button" data-toggle="dropdown">
		<span class="glyphicon glyphicon-option-vertical"></span>
	</button>
	<ul class="dropdown-menu dropdown-menu-right">
		@if (\Gate::denies('view', 'tests'))
        <li class="disabled">
        @else
        <li>
        @endif
			<a href="{{ url($folderPath, $folder->id) }}" data-modal-title="@lang('admin/tests.view_group')">
				<span class="glyphicon glyphicon-info-sign"></span>
				<div>@lang('common.info')</div>
			</a>
		</li>
		@if (\Gate::denies('update', 'tests'))
        <li class="disabled">
        @else
        <li>
        @endif
			<a href="{{ url($folderPath, [$folder->id, 'edit']) }}" data-modal-title="@lang('admin/tests.edit_group')">
				<span class="glyphicon glyphicon-edit"></span>
				<div>@lang('common.edit')</div>
			</a>
		</li>
		@if (\Gate::denies('update', 'tests'))
        <li class="disabled">
        @else
        <li>
        @endif
			<a href="{{ url($folderPath, [$folder->id, 'move']) }}" data-modal-title="@lang('admin/tests.move_group')">
				<span class="glyphicon glyphicon-transfer"></span>
				<div>@lang('common.move')</div>
			</a>
		</li>
		@if (\Gate::denies('delete', 'tests'))
        <li class="disabled">
        @else
        <li>
        @endif
			<a href="{{ url($folderPath, [$folder->id, 'delete']) }}" data-modal-title="@lang('admin/tests.delete_group')">
				<span class="glyphicon glyphicon-trash"></span>
				<div>@lang('common.delete')</div>
			</a>
		</li>
	</ul>
</div>