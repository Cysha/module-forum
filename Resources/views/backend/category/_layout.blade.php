<div class="row">
    <div class="col-md-{{ $col_one or '3'}}">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">Forum Category</div>
            </div>
            <div class="panel-body">@menu('backend_forum_category_menu')</div>
        </div>
    </div>
    <div class="col-md-{{ $col_two or '9'}}">
        @yield('category-form')
    </div>
</div>
