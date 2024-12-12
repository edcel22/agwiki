<div class="sidebar sidebar-default">
    <div class="widget-area">

        <aside class="widget widget_search">
            <h2 class="widget-title">Search</h2>
            <form class="search-form">
                <label class="ripple">
                    <span class="screen-reader-text">Search for:</span>
                    <input class="search-field" type="search" placeholder="Search" name="s">
                </label>
                <input type="submit" class="search-submit" value="Search">
            </form>
        </aside><!-- .widget_search -->

        <aside class="widget widget_categories">
            <h2 class="widget-title">Top Categories</h2>
            <ul>
                @foreach($topcategories as $category)
                    <li><a href="{{ route('category.posts', [$category->name, $category->id]) }}" title="{{ $category->name }}">{{ $category->name }}</a> ({{ $category->postCount() }})</li>
                @endforeach
            </ul>
        </aside><!-- .widget_categories -->
    </div><!-- .widget-area -->
</div><!-- .sidebar -->