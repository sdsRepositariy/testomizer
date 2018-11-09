<div class="dropdown action-menu">
    <button class="btn btn-app-flat btn-default dropdown-toggle" type="button" data-toggle="dropdown">
        <b>@lang('admin/actions.'.$actionMenu["title"])</b>
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li class="visible-xs-block visible-sm-block">
            <div class="text-primary">@lang('admin/actions.'.$actionMenu["title"])</div>
        </li>
        @foreach ($actionMenu["actions"] as $actionName => $action)
        @if ($action == false)
        <li class="disabled">
        @else
        <li>
        @endif
            <a href="{{ $action != false? $action: '#' }}" data-action-name="{{ $actionName }}" data-modal-title="@lang('admin/actions.'.$actionName)" data-parent-folder="{{ $folder->exists ? $folder->id : '' }}">
                <span class="glyphicon"></span>
                <div>@lang('admin/actions.'.$actionName)</div>
            </a>
        </li>
        @endforeach
    </ul>
</div>
<script>
    //Run handler
    $(function(){
        $('.action-menu').listActionModalLoader();
    }); 
</script>