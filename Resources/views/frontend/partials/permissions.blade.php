@if (!empty($category))
<div class="row">
    <div class="col-md-3 pull-right">
        <div class="panel panel-default">
            <table class="table table-bordered panel-body">
                <thead>
                    <th>Permission</th>
                    <th>Can</th>
                </thead>
                <tbody>
                    @set($perms, ['Create' => 'post', 'Read' => 'read', 'Reply' => 'reply', 'Delete' => 'delete', 'Moderate' => 'mod'])
                    @foreach($perms as $title => $perm)
                    <tr>
                        <td>{{ $title }}</td>
                        <td class="text-center">

                            {!! Lock::can($perm, 'forum_frontend', $category['id'])
                                ? '<i class="fa fa-check-square-o"></i>'
                                : '<i class="fa fa-square-o"></i>'
                            !!}

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
