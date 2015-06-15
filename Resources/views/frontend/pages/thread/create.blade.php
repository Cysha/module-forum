<div class="page-header">
    <h2>Create Thread</h2>
</div>

<div class="col-md-12">

{!! Former::open() !!}
    {!! Former::text('name')->label('Title') !!}
    {!! Form::DBSelect('category_id', $categories, ['id' => 'name'])->label('Category') !!}

    <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
        <label class="col-sm-3 control-label">Body</label>
        <div class="col-sm-9">
            @include(config('cms.core.app.default-editor'), ['id' => 'body', 'content' => null])
        </div>
    </div>

    <button class="btn-labeled btn btn-success pull-right" type="submit">
        <span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span> Create Post
    </button>

{!! Former::close() !!}

</div>
