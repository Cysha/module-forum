@if (isset($forum_categories))
<div class="list-group">
    <a href="{{ route('pxcms.forum.index') }}" class="list-group-item">
        {{ trans('forum::common.titles.all_threads') }}
    </a>

    @foreach($forum_categories as $category)
        <a href="{{ array_get($category, 'links.self') }}" class="list-group-item{{ Route::current() == array_get($category, 'links.self') ? ' active' : '' }}">
            <span class="badge pull-right">{{ array_get($category, 'thread_count') }}</span>
            {{ array_get($category, 'name') }}
        </a>
    @endforeach
</div>

@else
    <div class="alert alert-info">{{ trans('forum::common.messages.no_categories') }}</div>
@endif
