<table class="table table-striped">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th colspan="3" class="text-center">@lang('admin/users.student')</th>
            <th colspan="3" class="text-center">@lang('admin/users.parent')</th>
        </tr>
        <tr>
            <th class="sort">             
                @if($sort == 'level')
                <a href="{{ url($path, 'list').$queryString.'&sort=level&order='.$order }}" class='sort-link {{ "order-".$order }}'>
                    <span>@lang('admin/users.level')</span>
                    <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                </a>
                @else
                <a href="{{ url($path, 'list').$queryString.'&sort=level&order='.$order }}">
                    <span>@lang('admin/users.level')</span>
                    <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                </a>
                @endif
            </th>
            <th class="sort">
                @if($sort == 'stream')
                <a href="{{ url($path, 'list').$queryString.'&sort=stream&order='.$order }}" class='sort-link {{ "order-".$order }}'>
                    <span>@lang('admin/users.stream')</span>
                    <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                </a>
                @else
                <a href="{{ url($path, 'list').$queryString.'&sort=stream&order='.$order }}">
                    <span>@lang('admin/users.stream')</span>
                    <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                    </div>
                @endif
            </th>
            <th class="sort">
                @if($sort == 'student_last_name')
                <a href="{{ url($path, 'list').$queryString.'&sort=student_last_name&order='.$order }}" class='sort-link {{ "order-".$order }}'>
                    <span>@lang('admin/users.name')</span>
                    <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                </a>
                @else
                <a href="{{ url($path, 'list').$queryString.'&sort=student_last_name&order='.$order }}">
                    <span>@lang('admin/users.name')</span>
                    <span class="glyphicon spanphicon glyphicon-sort arrow-size"></span>
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
            <th>@lang('admin/users.action')</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list as $user)
            <tr>
                <td>{{ (($list->currentPage() - 1 ) * $list->perPage() ) + $loop->iteration }}</td>
                <td>{{ $user->level }}</td>
                <td>{{ $user->stream }}</td>
                <td>{{ $user->student_last_name }}&nbsp;{{ $user->student_first_name }}&nbsp;{{ $user->student_middle_name }}</td>
                <td>{{ $user->last_name }}&nbsp;{{ $user->first_name }}&nbsp;{{ $user->middle_name }}</td>
                <td>
                    @if($user->id)
                    <a class="btn btn-info btn-xs" href="{{ url($path.'/user', $user->id) }}" data-toggle="tooltip" title="@lang('admin/users.view')">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                    @else
                        @if(\Gate::allows('create', 'user'))
                        <a class="btn btn-default btn-xs" href="{{url($path.'/user/create/student', $user->student_id) }}" data-toggle="tooltip" title="@lang('admin/users.create_account')">
                        <span class="glyphicon glyphicon-plus"></span>
                        </a>
                        @endif
                    @endif
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