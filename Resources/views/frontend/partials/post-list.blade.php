@if (isset($posts))
    @foreach($posts as $post)

        @include(partial('forum::frontend.partials.post-single'), compact('post'))

    @endforeach

    @if (isset($pagination) && $pagination->count())

        {!! $pagination->render() !!}

    @endif

@else

    <div class="alert alert-warning"><strong>Warning:</strong> No Posts in this Thread.</div>

@endif
