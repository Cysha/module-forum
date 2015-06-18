<div class="forum-partials thread-row">
    <div class="avatar text-center">
        <img src="{{ array_get($thread, 'author.avatar') }}" class="img-circle">
    </div>
    <div class="info">
        <div class="row">
            <h4><a href="{{ array_get($thread, 'links.self') }}">{{ str_limit(array_get($thread, 'name'), 50) }}</a></h4>
        </div>
        <div class="row">
            <a href="{{ array_get($thread, 'category.links.self') }}">
                {!! array_get($thread, 'category.label') !!}
            </a>&nbsp;
            @if (array_get($thread, 'post_count')-1 <= 0)
            <span>Posted {!! array_get($thread, 'created.element') !!} by {!! array_get($thread, 'author.link') !!}</span>
            @else
            <span>Last Updated {!! array_get($thread, 'latestPost.updated.element') !!} by {!! array_get($thread, 'latestPost.author.link') !!}</span>
            @endif
        </div>
    </div>
    <div class="replies text-center">
        <div class="row"><h4><a href="{{ array_get($thread, 'links.last_post') }}">{{ array_get($thread, 'post_count')-1 }}</a></h4></div>
        <div class="row">Replies</div>
    </div>
    <div class="clearfix"></div>
</div>
