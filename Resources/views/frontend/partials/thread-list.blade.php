@forelse ($threads as $thread)

    @include(partial('forum::frontend.partials.thread-single'), compact('thread'))

@empty

    <div class="alert alert-warning"><strong>Warning:</strong> No Threads in this Category.</div>

@endforelse
