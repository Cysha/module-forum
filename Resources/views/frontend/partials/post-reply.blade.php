@if (isset($thread))
<div class="page-header">
    <h3>Reply To Thread</h3>
</div>

<div class="col-md-12">

{!! Former::open() !!}
    <div class="form-group">
        <div class="col-md-2 text-center">
            <img src="{{ Auth::user()->avatar }}" class="img-circle">
        </div>
        <div class="col-md-10">
            <strong>{{ Auth::user()->screenname }}</strong>

            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
            @include(config('cms.core.app.default-editor'), ['id' => 'body', 'content' => null])
            </div>
            <span class="help-block">
                <i class="fa fa-question-circle"></i> Fully supports github style markdown</span>
            </div>
        </div>
    </div>

    <button class="btn-labeled btn btn-success pull-right" type="submit">
        <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span> Reply to Post
    </button>

{!! Former::close() !!}

</div>
@endif
