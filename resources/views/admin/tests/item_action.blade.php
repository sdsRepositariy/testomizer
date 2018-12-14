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
			<a href="{{ url($itemPath, $item->id) }}" data-modal-title="@lang('admin/tests.view_test')">
				<span class="glyphicon glyphicon-info-sign"></span>
				<div>@lang('common.info')</div>
			</a>
		</li>
		<li>
			<a href="#">
				<span class="glyphicon glyphicon-ok-circle"></span>
				<div>Run test</div>
			</a>
		</li>
		@if (\Gate::denies('update', 'tests'))
        <li class="disabled">
        @else
        <li>
        @endif
			<a href="{{ url($itemPath, [$item->id, 'edit']) }}" data-modal-title="@lang('admin/tests.edit_test')">
				<span class="glyphicon glyphicon-edit"></span>
				<div>@lang('common.edit')</div>
			</a>
		</li>
		@if (\Gate::denies('update', 'tests'))
        <li class="disabled">
        @else
        <li>
        @endif
			<a href="{{ url($itemPath, [$item->id, 'move']) }}" data-modal-title="@lang('admin/tests.move_test')">
				<span class="glyphicon glyphicon-transfer"></span>
				<div>@lang('common.move')</div>
			</a>
		</li>
		@if (\Gate::denies('delete', 'tests'))
        <li class="disabled">
        @else
        <li>
        @endif
			<a href="{{ url($itemPath, [$item->id, 'delete']) }}" data-modal-title="@lang('admin/tests.delete_test')">
				<span class="glyphicon glyphicon-trash"></span>
				<div>@lang('common.delete')</div>
			</a>
		</li>
	</ul>
</div>