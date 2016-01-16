<div class="page-header">
    <h2>Update Post &raquo; <small>{{ array_get($thread, 'name') }}</small></h2>
</div>

<div class="col-md-12">

{!! Former::open() !!}
    <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
        <label class="col-sm-3 control-label">Body</label>
        <div class="col-sm-9">
            @include(config('cms.core.app.default-editor'), ['id' => 'body', 'content' => array_get($post, 'original_body')])
        </div>
    </div>

    <button class="btn-labeled btn btn-success pull-right" type="submit">
        <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span> Update Post
    </button>

{!! Former::close() !!}

</div>

@debug($post)
