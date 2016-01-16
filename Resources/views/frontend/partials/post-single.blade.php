<div class="forum-partials post-row" id="post-{{ array_get($post, 'id') }}">
    <div class="dropdown">
        <span class="dropdown-toggle" type="button" data-toggle="dropdown">
            <span class="glyphicon glyphicon-chevron-down"></span>
        </span>
        <ul class="dropdown-menu" role="menu">
            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ array_get($post, 'links.self') }}">Link to Post</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ array_get($post, 'links.edit') }}">Edit Post</a></li>
            {{-- <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Quote Post</a></li> --}}
        </ul>
    </div>
    <div class="panel-tags">
        <ul>
            <li>{{ array_get($thread, 'category.name') }}</li>
        </ul>
    </div>
    <div class="panel-heading">
        <img class="img-circle pull-left" src="{{ array_get($post, 'author.avatar') }}" />
        <h3>{!! array_get($post, 'author.links.html') !!}</h3>
        <h5><span>Posted</span> - {!! array_get($post, 'created.element') !!} </h5>
    </div>
    <div class="panel-body">
        <p>{!! array_get($post, 'body') !!}</p>
    </div>
    <div class="clearfix"></div>
</div>
