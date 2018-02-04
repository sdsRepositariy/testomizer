<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th class="sort">             
                @if($sort == 'role')
                <a href="{{ url($path, 'list').$queryString.'&sort=role&order='.$order }}" class='sort-link {{ "order-".$order }}'>
                    <span>@lang('admin/users.role')</span>
                    <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                </a>
                @else
                <a href="{{ url($path, 'list').$queryString.'&sort=role&order='.$order }}">
                    <span>@lang('admin/users.role')</span>
                    <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                </a>
                @endif
            </th>
            <th class="sort">
                @if($sort == 'last_name')
                <a href="{{ url($path, 'list').$queryString.'&sort=last_name&order='.$order }}" class='sort-link {{ "order-".$order }}'>
                    <span>@lang('admin/users.name')</span>
                    <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                </a>
                @else
                <a href="{{ url($path, 'list').$queryString.'&sort=last_name&order='.$order }}">
                    <span>@lang('admin/users.name')</span>
                    <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                </a>
                @endif
            </th>
            <th>@lang('admin/users.email')</th>
            <th>@lang('admin/users.status')</th>
            <th colspan="2">@lang('admin/users.action')</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list as $user)
            <tr>
                <td>{{ (($list->currentPage() - 1 ) * $list->perPage() ) + $loop->iteration }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->last_name }}&nbsp;{{ $user->first_name }}&nbsp;{{ $user->middle_name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                @if ( $user->deleted_at == null )
                    <span class="text-success glyphicon glyphicon-ok"></span>
                @else
                    <span class="text-danger glyphicon glyphicon-trash"></span>
                @endif
                </td>
                <td>
                @if ( $user->deleted_at == null )
                    <a class="btn btn-info btn-xs" href="{{ url($path.'/user', $user->id) }}" data-toggle="tooltip" title="@lang('admin/users.view')">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                @else
                    @if (\Gate::allows('delete', 'user-'.$user->role))
                    <form method="POST" action="{{ url($path.'/user/'.$user->id.'/restore') }}">
                    {{ csrf_field() }}
                        <button type="submit" class="btn btn-success btn-xs" data-toggle="tooltip" title="@lang('admin/users.restore')">
                            <span class="glyphicon glyphicon-refresh"></span>
                        </button>
                    </form>
                    @endif
                @endif
                </td>
                <td>
                @if ( $user->deleted_at == null )
                    <form method="POST" action="{{ url($path.'/user', $user->id) }}">
                    {{ method_field('DELETE') }}
                @else
                    <form method="POST" action="{{ url($path.'/user/'.$user->id.'/harddelete') }}">
                @endif
                    {{ csrf_field() }}

                @if (\Gate::allows('delete', 'user-'.$user->role))
                    <button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" title="@lang('admin/users.delete')">
                    @if ( $user->deleted_at == null )
                        <span class="glyphicon glyphicon-trash"></span>
                    @else
                        <span class="glyphicon glyphicon-remove"></span>
                    @endif
                    </button>
                @endif
                    </form> 
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
(function($){
$(function(){

//Handle sorting
$("th .order-desc .glyphicon").removeClass().addClass("glyphicon glyphicon-sort-by-alphabet-alt arrow-size");
$("th .order-asc .glyphicon").removeClass().addClass("glyphicon glyphicon-sort-by-alphabet arrow-size");


});
})(jQuery);   
</script>