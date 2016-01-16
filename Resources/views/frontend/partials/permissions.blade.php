@if (!empty($category) && Auth::check())
<div class="row">
    <div class="col-md-3 pull-right">
        <div class="panel panel-default">
            <table class="table table-bordered panel-body">
                <thead>
                    <th>{{ trans('forum::common.titles.permission') }}</th>
                    <th>{{ trans('forum::common.titles.can') }}</th>
                </thead>
                <tbody>
                    @set($perms, [trans('forum::common.permissions.create') => 'post', trans('forum::common.permissions.read') => 'read', trans('forum::common.permissions.reply') => 'reply', trans('forum::common.permissions.delete') => 'delete', trans('forum::common.permissions.moderate') => 'mod'])
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
