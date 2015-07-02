<table class="table table-striped table-bordered">
    <thead>
        <tr role="row">
            <th width="15%">Category Name</th>
            @foreach($perms as $perm => $desc)
            <th width="{{ 85/count($perms) }}%" colspan="{{ count($roles) }}">Perm: {{ $perm }}</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{ $category->name }}</td>
            @foreach($perms as $perm => $desc)
                @foreach($roles as $role)
                <td><span class="label label-default">
                {!! app('BeatSwitch\Lock\Manager')
                    ->role($role->name)
                    ->can($perm, 'forum_frontend', $category->id)
                        ? '<i class="fa fa-check-square-o"></i>'
                        : '<i class="fa fa-square-o"></i>'
                !!}&nbsp;{{ $role->name }}
                </span></td>
                @endforeach
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>

<table class="table table-striped table-bordered">
    <thead>
        <tr role="row">
            <th width="5%">Permission</th>
            @foreach($categories as $category)
            <th width="{{ 95/count($categories) }}%" colspan="{{ count($roles) }}">Category: {{ $category->name }}</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach($perms as $perm => $desc)
        <tr>
            <td>{{ ucwords($perm) }}</td>
            @foreach($categories as $category)
                @foreach($roles as $role)
                <td>
                {!! app('BeatSwitch\Lock\Manager')
                    ->role($role->name)
                    ->can($perm, 'forum_frontend', $category->id)
                        ? '<span class="label label-default"><i class="fa fa-check-square-o"></i> '.$role->name.'</span>'
                        : '&nbsp;'
                !!}
                </td>
                @endforeach
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>

<table class="table table-striped table-bordered">
    <thead>
        <tr role="row">
            <th width="5%">Permission</th>
            @foreach($roles as $role)
            <th width="{{ 95/count($roles) }}%" colspan="{{ count($perms) }}">Role: {{ $role->name }}</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{ $category->name }}</td>
            @foreach($roles as $role)
                @foreach($perms as $perm => $desc)
                <td><span class="label label-default">
                {!! app('BeatSwitch\Lock\Manager')
                    ->role($role->name)
                    ->can($perm, 'forum_frontend', $category->id)
                        ? '<i class="fa fa-check-square-o"></i>'
                        : '<i class="fa fa-square-o"></i>'
                !!}&nbsp;{{ $perm }}
                </span></td>
                @endforeach
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>


<div class="row">
    @foreach($categories as $category)
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">{{ $category->name }}</div>
            </div>
            <div class="panel-body">
                @set($header, null)
                @foreach($roles as $role)
                    @if($header !== $role->name)
                        @set($header, $role->name)

                        <div class="page-header">
                            <h4>{{ $role->name }}</h4>
                        </div>
                    @endif

                    <div class="col-md-12">
                    @foreach($perms as $perm => $desc)

                        @set($checked, (bool)app('BeatSwitch\Lock\Manager')->role($role->name)->can($perm, 'forum_frontend', $category->id))
                        @set($permission, sprintf('permissions[%s][%s][%d]', 'forum_frontend', $perm, $category->id))
                        <div class="col-md-4">
                        @if($checked) {!! Former::checkbox($permission, false)->check() !!}
                        @else {!! Former::checkbox($permission, false)->value(null) !!}
                        @endif

                        &nbsp;{{ ucwords($perm) }}
                        </div>

                    @endforeach
                    </div>
                    <div class="clearfix"></div>
                @endforeach
            </div>
        </div>
    </div>

    @endforeach
</div>
