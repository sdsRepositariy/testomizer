<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th class="sort">             
                @if($sort == 'region')
                <a href="{{ url($path).$queryString.'&sort=region&order='.$order }}" class='sort-link {{ "order-".$order }}'>
                    <span>@lang('admin/settings.region')</span>
                    <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                </a>
                @else
                <a href="{{ url($path).$queryString.'&sort=region&order='.$order }}">
                    <span>@lang('admin/settings.region')</span>
                    <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                </a>
                @endif
            </th>
            <th class="sort">
                @if($sort == 'city')
                <a href="{{ url($path).$queryString.'&sort=city&order='.$order }}" class='sort-link {{ "order-".$order }}'>
                    <span>@lang('admin/settings.city')</span>
                    <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                </a>
                @else
                <a href="{{ url($path).$queryString.'&sort=city&order='.$order }}">
                    <span>@lang('admin/settings.city')</span>
                    <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                </a>
                @endif
            </th>
            <th class="sort">
                @if($sort == 'community_type')
                <a href="{{ url($path).$queryString.'&sort=community_type&order='.$order }}" class='sort-link {{ "order-".$order }}'>
                    <span>@lang('admin/settings.community_type')</span>
                    <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                </a>
                @else
                <a href="{{ url($path).$queryString.'&sort=community_type&order='.$order }}">
                    <span>@lang('admin/settings.community_type')</span>
                    <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                </a>
                @endif
            </th>
            <th class="sort">
                @if($sort == 'name')
                <a href="{{ url($path).$queryString.'&sort=name&order='.$order }}" class='sort-link {{ "order-".$order }}'>
                    <span>@lang('admin/settings.name')</span>
                    <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                </a>
                @else
                <a href="{{ url($path).$queryString.'&sort=name&order='.$order }}">
                    <span>@lang('admin/settings.name')</span>
                    <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                </a>
                @endif
            </th>
            <th class="sort">
                @if($sort == 'number')
                <a href="{{ url($path).$queryString.'&sort=number&order='.$order }}" class='sort-link {{ "order-".$order }}'>
                    <span>@lang('admin/settings.number')</span>
                    <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                </a>
                @else
                <a href="{{ url($path).$queryString.'&sort=number&order='.$order }}">
                    <span>@lang('admin/settings.number')</span>
                    <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                </a>
                @endif
            </th>
            <th>@lang('admin/settings.action')</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list as $community)
            <tr>
                <td>{{ (($list->currentPage() - 1 ) * $list->perPage() ) + $loop->iteration }}</td>
                <td>{{ $community->region }}</td>
                <td>{{ $community->city }}</td>
                <td>{{ $community->community_type }}</td>
                <td>{{ $community->name }}</td>
                <td>{{ $community->number }}</td>
                <td>
                    <a class="btn btn-info btn-xs" href="{{ url($path, $community->id) }}" data-toggle="tooltip" title="@lang('admin/settings.view')">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
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