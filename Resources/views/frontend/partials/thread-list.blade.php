@if (isset($threads) && $threads->count())
    @foreach($threads as $thread)

        @include(partial('forum::frontend.partials.thread-single'), compact('thread'))

    @endforeach

    @include(partial('forum::frontend.partials.pagination'), compact('pagination'))

@else

    <div class="alert alert-warning"><strong>Warning:</strong> No Threads in this Category.</div>

@endif
