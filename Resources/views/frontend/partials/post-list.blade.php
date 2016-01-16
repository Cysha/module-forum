@if (isset($posts) && $posts->count())
    @foreach($posts as $post)

        @include(partial('forum::frontend.partials.post-single'), compact('post'))

    @endforeach

    @include(partial('forum::frontend.partials.pagination'), compact('pagination'))

@else

    <div class="alert alert-warning"><strong>Warning:</strong> No Posts in this Thread.</div>

@endif
