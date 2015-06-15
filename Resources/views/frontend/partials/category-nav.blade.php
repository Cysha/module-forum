@if (isset($categories) && !empty($categories))
    <ul class="nav nav-tabs">
        {{ HTML::nav_link('pxcms.forum.index', 'All') }}
    @foreach ($categories as $category)

        {{ HTML::nav_link('forum.category.view', array_get($category, 'title'), [
            'category_id' => array_get($category, 'id'),
            'name' => array_get($category, 'slug')
        ]) }}

    @endforeach
    </ul>
@else
    <div class="alert alert-info">No Categories Found</div>
@endif
