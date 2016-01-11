@extends(partial('auth::admin.user._layout'))

@section('user-form')

@if(empty($keys))

    <div class="alert alert-info">
        <strong>Information:</strong> You will need some Forum Categories to assign permissions to...
    </div>
@else
{!! Former::horizontal_open() !!}
    <div class="panel panel-default panel-permissions">
        <div class="panel-heading">
            <h3 class="panel-title">Permissions</h3>
        </div>
        <div class="panel-body no-padding row">
            <?php
                $tier_one = [];
                $tier_two = [];
                foreach ($keys as $key) {
                    list($a, $b) = explode('_', $key);
                    $tier_one[] = $a;
                    $tier_two[$a][$key] = $b;
                }
                $tier_one = array_unique($tier_one);

            ?>
            <div class="col-md-2 permissions-nav categories">
                <ul class="nav nav-pills nav-stacked" id="permissions">
                    <li class="disabled">Categories</li>
                @set($active_t1, false)
                @foreach($tier_one as $category)
                    @if($active_t1 === false)
                        @set($active_t1, true)
                        <li class="active">
                    @else
                        <li>
                    @endif

                        <a href="#t1_{{ str_slug($category) }}" data-toggle="pill">{{ ucwords($category) }}</a>
                    </li>
                @endforeach
                </ul>
            </div>

            <div class="col-md-10">
                <div class="tab-content">
                @set($active_t1, false)
                @foreach($tier_one as $category)
                    @if($active_t1 === false)
                        @set($active_t1, true)
                        <div class="tab-pane active" id="t1_{{ str_slug($category) }}">
                    @else
                        <div class="tab-pane" id="t1_{{ str_slug($category) }}">
                    @endif

                        <div class="row">
                            <div class="col-md-3 permissions-nav roles">
                                <ul class="nav nav-pills nav-stacked" id="permissions">
                                    <li class="disabled">Roles</li>

                                @set($active_t2, false)
                                @foreach($tier_two[$category] as $role)
                                    @if($active_t2 === false)
                                        @set($active_t2, true)
                                        <li class="active">
                                    @else
                                        <li>
                                    @endif

                                        <a href="#t2_{{ str_slug($category.'_'.$role) }}" data-toggle="pill">{{ ucwords($role) }}</a>
                                    </li>
                                @endforeach
                                </ul>
                            </div>

                            <div class="col-md-9">
                                <div class="tab-content">
                                @set($active_t2, false)
                                @foreach($tier_two[$category] as $role)
                                    @if($active_t2 === false)
                                        @set($active_t2, true)
                                        <div class="tab-pane active" id="t2_{{ str_slug($category.'_'.$role) }}">
                                    @else
                                        <div class="tab-pane" id="t2_{{ str_slug($category.'_'.$role) }}">
                                    @endif

                                        @set($category_id, $categories->filter(function($row) use($category) { return (strtolower($row->name) === $category); })->first()->id)
                                        @set($perms, $permissions->filter(function($row) use($category_id) { return str_contains($row->resource_type, 'forum_frontend') && ($row->resource_id == $category_id); }))
                                        @set($role_info, $roles->filter(function($row) use($role) { return (strtolower($row->name) === $role); })->first())

                                        @include(partial('forum::backend.partials.category-permissions'), [
                                            'title' => ucwords($category.' &raquo; '.$role),
                                            'permissions' => $perms,
                                            'role' => $role_info,
                                            'resource_id' => $category_id
                                        ])

                                    </div>
                                @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
                </div>
            </div>

        </div>
        <div class="panel-footer clearfix">
            <button class="btn-labeled btn btn-success pull-right" type="submit">
                <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span> Save Permissions
            </button>
        </div>
    </div>
{!! Former::close() !!}

<script>
(function ($) {
    $('select.master-select').on('change', function () {
        var value = $(this).find(':selected').attr('class');

        $(this)
            .parents('.permission-groups')      /* goto parent */
            .find('.permission-row select')     /* find the children select boxes */
            .val(value)                         /* change the values */
            .change();                          /* trigger a change to make it update */
    });
})(jQuery);
</script>
@endif
@stop
