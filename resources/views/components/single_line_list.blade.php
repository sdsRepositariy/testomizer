<ul class="list-group single-line-avatar">
	@foreach ($folders as $folder)	
	<li class="list-group-item">
		<a href="{{ url($folderPath, $folder->id).'/list' }}" class="list-description list-primary-action">
			<div class="row">
				<div class="col-xs-10 col-sm-11">
					<div class="list-item-avatar avatar-default">
						<span class="glyphicon glyphicon-folder-close"></span>
					</div>
					<div class="list-item-text">{{ $folder->name }}</div>
				</div>
				<div class="col-xs-2 col-sm-1 list-item-badge">
					<span class="badge">{{ $folder->items_count }}</span>
				</div>
			</div>
		</a>

		@if (isset($folderAction))
		 	@include($folderAction)
		@endif

	</li>
	@endforeach

	@if($folders->isNotEmpty() && $items->isNotEmpty())
	<li class="list-divider visible-xs-block visible-sm-block">
		<div class="subheader clearfix">
			<div class="row">
				<div class="col-xs-6 hidden-lg hidden-md">
					<div class="text-muted pull-left">@lang('admin/tasks.tasks')</div>
				</div>
			</div>
		</div>
	</li>
	@endif

	@foreach ($items as $item)
	<li class="list-group-item">
		<div class="list-description">
			<div class="row">
				<div class="col-xs-12">
					<div class="list-item-avatar avatar-primary">
						<span class="glyphicon glyphicon-file"></span>
					</div>
					<div class="list-item-text">{{ $item->name }}</div>
				</div>
			</div>
		</div>

		@if (isset($itemAction))
		 	@include($itemAction)
		@endif

	</li>	
	@endforeach
</ul>