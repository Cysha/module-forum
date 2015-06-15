<div class="page-header">
    <h2>
        {{ array_get($category, 'name', 'All Threads') }}
        @if (Auth::check() && Lock::can('post', 'forum_frontend', $category['id']))
            <a href="{{ array_get($category, 'links.create') }}" class="btn-labeled btn btn-success pull-right">
                <span class="btn-label"><i class="fa fa-plus fa-fw"></i></span> New Thread
            </a>

        @endif
    </h2>
</div>

@include(partial('forum::frontend.partials.thread-list'), compact('threads'))

@include(partial('forum::frontend.partials.permissions'), compact('category'))
@include(partial('forum::frontend.partials.group-permissions'))
