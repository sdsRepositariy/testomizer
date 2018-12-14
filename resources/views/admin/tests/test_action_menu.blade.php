<div class="dropdown action-menu">
    <button class="btn btn-app-flat btn-default dropdown-toggle" type="button" data-toggle="dropdown">
        <b>@lang('admin/actions.create')</b>
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li class="visible-xs-block visible-sm-block">
            <div class="text-primary">@lang('admin/actions.create')</div>
        </li>
        @if (\Gate::denies('create', 'tests'))
        <li class="disabled">
        @else
        <li>
        @endif
            <a href="{{ action('Tests\FolderController@create') }}" data-modal-title="@lang('admin/actions.create_folder')" data-parent-folder="{{ $folder->exists ? $folder->id : '' }}">
                <span class="glyphicon glyphicon-folder-close"></span>
                <div>@lang('admin/actions.create_folder')</div>
            </a>
        </li>
        @if (\Gate::denies('create', 'tests'))
        <li class="disabled">
        @else
        <li>
        @endif
            <a href="{{ action('Tests\ItemController@create') }}" data-parent-folder="{{ $folder->exists ? $folder->id : '' }}">
                <span class="glyphicon glyphicon-file"></span>
                <div>@lang('admin/actions.create_test_item')</div>
            </a>
        </li>
    </ul>
</div>
<script>
    //Run handler
    $(function(){
        $('.action-menu').listActionModalLoader();
    }); 
</script>