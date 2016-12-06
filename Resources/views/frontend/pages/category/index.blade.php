<div class="page-header">
    <h2>
        {{ array_get($category, 'name', trans('forum::common.titles.all_threads')) }}
        @if (Auth::check() && hasPermission('post', 'forum_frontend', $category['id']))

            @if (array_get($category, 'name', null) !== null)
            <a href="{{ array_get($category, 'links.create') }}" class="btn-labeled btn btn-success pull-right">
                <span class="btn-label"><i class="fa fa-comment fa-fw"></i></span> {{ trans('forum::common.titles.new_thread') }}
            </a>
            @endif

        @endif
    </h2>
</div>

@include(partial('forum::frontend.partials.thread-list'), compact('threads'))

@include(partial('forum::frontend.partials.permissions'), compact('category'))
{{-- @include(partial('forum::frontend.partials.group-permissions')) --}}

