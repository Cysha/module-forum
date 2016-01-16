@if (isset($categories) && !empty($categories))
    <ul class="nav nav-tabs">
        {{ HTML::nav_link('pxcms.forum.index', trans('forum::common.titles.all_threads')) }}
    @foreach ($categories as $category)

        {{ HTML::nav_link('forum.category.view', array_get($category, 'title'), [
            'category_id' => array_get($category, 'id'),
            'name' => array_get($category, 'slug')
        ]) }}

    @endforeach
    </ul>
@else
    <div class="alert alert-warning"><strong>Warning:</strong> {{ trans('forum::common.messages.no_categories') }}</div>
@endif
