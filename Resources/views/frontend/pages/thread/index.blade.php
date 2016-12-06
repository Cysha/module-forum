@if (isset($thread))
    <div class="page-header">
        <h2>
            {{{ array_get($thread, 'name') }}}
            @if (Auth::check() && hasPermission('reply', 'forum_frontend', array_get($thread, 'category.id')))
                <a href="{{ array_get($thread, 'links.reply') }}" class="btn-labeled btn btn-success pull-right">
                    <span class="btn-label"><i class="fa fa-comments fa-fw"></i></span> {{ trans('forum::common.titles.reply') }}
                </a>

            @endif
        </h2>
    </div>

    @include(partial('forum::frontend.partials.post-list', compact('posts')))

    @if (Auth::check() && hasPermission('reply', 'forum_frontend', array_get($thread, 'category.id')))
        @include(partial('forum::frontend.partials.post-reply', compact('thread')))
    @endif
@endif
