@if(!Auth::guest() && Auth::user()->isAdmin())
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            Permission Tester
        </div>
        <table class="table table-bordered panel-body">
            @set($perms, ['Create' => 'post', 'Read' => 'read', 'Reply' => 'reply', 'Delete' => 'delete', 'Moderate' => 'mod'])
            @set($categories, with(new \Cms\Modules\Forum\Models\Category)->orderBy('order', 'asc')->get())
            @set($roles, with(new \Cms\Modules\Auth\Models\Role)->all())


            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->name }}:{{ $category->id }}</td>

                @foreach($perms as $title => $perm)
                    <td class="text-center">
                        <small>{{ $title }}</small><br />

                        @set($counter, 0)
                        @foreach ($roles as $role)
                            @set($counter, $counter+1)

                        <span class="label label-default">
                        {!! app('BeatSwitch\Lock\Manager')
                            ->role($role->name)
                            ->can($perm, 'forum_frontend', $category->id)
                                ? '<i class="fa fa-check-square-o"></i>'
                                : '<i class="fa fa-square-o"></i>'
                        !!}&nbsp;{{ $role->name }}
                        </span>&nbsp;
                        @if ($counter % 2 === 0)
                            <br />
                        @endif

                        @endforeach
                    </td>
                @endforeach

                </tr>
            @endforeach
        </table>
    </div>
</div>
@endif
