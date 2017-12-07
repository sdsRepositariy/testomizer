<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            @if($usergroup == "teachers")
            <th>Role</th>
            @endif
            <th>Login</th>
            <th class="sort">
                <div class="pull-left">Last name</div>
                <div class="pull-right">
                    <a href="#" class='sort-link 
                    {{ $session["sort"]=="last_name" ? "hidden" : "" }}'>
                        <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                    </a>
                    <a href="{{ url($slug.'?sort=last_name&last_name=asc') }}" class='sort-link {{ ($session["order"]=="asc" && $session["sort"]=="last_name") ? "" : "hidden" }}'>
                        <span class="glyphicon glyphicon-sort-by-alphabet arrow-size"></span>
                    </a>
                    <a href="{{ url($slug.'?sort=last_name&last_name=desc') }}" class='sort-link {{ ($session["order"]=="desc" && $session["sort"]=="last_name") ? "" : "hidden" }}'>
                        <span class="glyphicon glyphicon-sort-by-alphabet-alt arrow-size"></span>
                    </a>

                </div>
            </th>
            <th class="sort">
                <div class="pull-left">First name</div>
                <div class="pull-right">
                    <a href="#" class='sort-link {{  $session["sort"]=="first_name" ? "hidden" : "" }}'>
                        <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                    </a>
                    <a href="{{ url($slug.'?sort=first_name&first_name=asc') }}" class='sort-link {{ ($session["order"]=="asc" && $session["sort"]=="first_name") ? "" : "hidden" }}'>
                        <span class="glyphicon glyphicon-sort-by-alphabet arrow-size"></span>
                    </a>
                    <a href="{{ url($slug.'?sort=first_name&first_name=desc') }}" class='sort-link {{ ($session["order"]=="desc" && $session["sort"]=="first_name") ? "" : "hidden" }}'>
                        <span class="glyphicon glyphicon-sort-by-alphabet-alt arrow-size"></span>
                    </a>
                </div>
            </th>
            @if($usergroup == "parents")
            <th>Parent</th>
            @endif
            <th>Email</th>
            <th>Status</th>
            @if($usergroup != "parents")
            <th class="sort">
                <div class="pull-left">Created</div>
                <div class="pull-right">
                    <a href="#" class='sort-link {{ $session["sort"]=="created_at" ? "hidden" : "" }}'>
                        <span class="glyphicon glyphicon glyphicon-sort arrow-size"></span>
                    </a>
                    <a href="{{ url($slug.'?sort=created_at&created_at=asc') }}" class='sort-link {{ ($session["order"]=="asc" && $session["sort"]=="created_at") ? "" : "hidden" }}'>
                        <span class="glyphicon glyphicon-sort-by-alphabet arrow-size"></span>
                    </a>
                    <a href="{{ url($slug.'?sort=created_at&created_at=desc') }}" class='sort-link {{ ($session["order"]=="desc" && $session["sort"]=="created_at") ? "" : "hidden" }}'>
                        <span class="glyphicon glyphicon-sort-by-alphabet-alt arrow-size"></span>
                    </a>
                </div>
            </th>
            @endif
            <th colspan="{{ $usergroup=='parents' ? '3' : '2'}}">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list as $user)
            <tr>
                <td>{{ (($list->currentPage() - 1 ) * $list->perPage() ) + $loop->iteration }}</td>
                @if($usergroup == "teachers")
                <td>{{ $user->role->role }}</td>
                @endif
                <td>{{ $user->login }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->first_name }}</td>
                @if($usergroup == "parents")
                <td>
                @if($user->parent != null)
                    {{ $user->parent->last_name.'&nbsp;'.$user->parent->first_name}}
                @endif
                </td>
                <td>
                @if($user->parent != null)
                    {{$user->parent->email}}
                @endif
                </td>
                @else
                <td>{{ $user->email }}</td>
                @endif
                <td>
                @if ( !$user->trashed() )
                    <span class="text-success glyphicon glyphicon-ok"></span>
                @else
                    <span class="text-danger glyphicon glyphicon-trash"></span>
                @endif
                </td>
                @if($usergroup != 'parents')
                <td>
                @if($user->created_at != null)
                   {{ $user->created_at->toDateString() }}
                @endif
                </td>
                @endif
                @if($usergroup == 'parents'&& \Gate::allows('create', 'user'))
                <td>
                    <form class="form-horizontal" method="GET" action="{{ url($slug, 'create') }}">
                        <input type="hidden" name="student" value="{{ $user->id }}">
                        <button class="btn btn-default btn-xs" data-toggle="tooltip" title="Add user" type='submit'>
                            <span class=" glyphicon glyphicon-plus"></span>
                        </button>
                    </form>
                </td>
                @endif
                <td>
                @if ( !$user->trashed() )
                    <a class="btn btn-info btn-xs" href="{{ url($slug, $user->id) }}" data-toggle="tooltip" title="View user">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                @else
                    <form method="POST" action="{{ url($slug.'/'.$user->id.'/restore') }}">
                    {{ csrf_field() }}
                        <button type="submit" class="btn btn-success btn-xs" data-toggle="tooltip" title="Restore user">
                            <span class="glyphicon glyphicon-refresh"></span>
                        </button>
                    </form>
                @endif
                </td>
                <td>
                @if ( !$user->trashed() )
                    <form method="POST" action="{{ url($slug, $user->id) }}">
                    {{ method_field('DELETE') }}
                @else
                    <form method="POST" action="{{ url($slug.'/'.$user->id.'/harddelete') }}">
                @endif
                    {{ csrf_field() }}

                @if (\Gate::allows('delete', 'user'))
                    <button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete user">
                    @if ( !$user->trashed() )
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