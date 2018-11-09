<div class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"></h4>
			</div>
			<div class="modal-body">
				@yield('body')
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">@lang('common.close')</button>
				
				@if(explode('@', \Route::currentRouteAction())[1] == 'edit' || explode('@', \Route::currentRouteAction())[1] == 'create' )
					<button id="app_modal_submit" type="submit" class="btn btn-primary">@lang('common.save')</button>
					<script>
						$("#app_modal_submit").submitModalForm();
					</script>
				@elseif(explode('@', \Route::currentRouteAction())[1] == 'delete')
					<button id="app_modal_submit" type="submit" class="btn btn-primary">@lang('common.delete')</button>
					<script>
						$("#app_modal_submit").submitModalForm();
					</script>
				@elseif(explode('@', \Route::currentRouteAction())[1] == 'moveFolder')
					<button id="app_modal_submit" type="button" name="move_folder" class="btn btn-primary" data-target="{{ $targetFolder->id }}" data-path="{{ url($folderPath) }}">@lang('common.move_here')</button>
					<script>
						$("#app_modal_submit").submitModalList();
					</script>
				@elseif(explode('@', \Route::currentRouteAction())[1] == 'moveItem')
					<button id="app_modal_submit" type="button" name="move_item" class="btn btn-primary" data-target="{{ $targetItem->id }}" data-task-folder="{{ $folder->id }}" data-path="{{ url($itemPath) }}">@lang('common.move_here')</button>
					<script>
						$("#app_modal_submit").submitModalList();
					</script>
				@endif
			</div>
		</div>
	</div>
</div>