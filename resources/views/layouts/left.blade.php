<section class="blog-left-section text-right">
    <div class="avatar">
        <a href="{{ route('index') }}"><img src="{{ config('app.storage_host') }}/storage/images/avatar.jpeg" width="80" alt="avatar"></a>
    </div>
    <div class="blog-introduce blog-nav">
        <h4>{{ Cache::get('SETTINGS')['SITE_NAME'] }}</h4>
        <i>{{ Cache::get('SETTINGS')['SITE_SLOGAN'] }}</i>
        <div class="menus">
            @foreach(Cache::get('SITE_CATALOGS')['main'] as $catalog)
                <a href="{{ url($catalog['action']) }}">{{ $catalog['name'] }}</a>
            @endforeach
        </div>
        <hr>
    </div>

    @if(isset(Cache::get('SITE_SIDEBARS')['categories']))
        <div class="blog-categories blog-nav">
            <h3>Categories</h3>
            @foreach(Cache::get('SITE_SIDEBARS')['categories'] as $category)
                <a href="{{ route('category', $category['id']) }}">{{ $category['name'] }}</a>
            @endforeach
        </div>
    @endif
    @if(isset(Cache::get('SITE_SIDEBARS')['filings']))
        <div class="blog-categories blog-nav">
            <div class="blog-filing blog-nav">
                <h3>Filing</h3>
                @foreach(Cache::get('SITE_SIDEBARS')['filings'] as $filing)
                    <a href="{{ route('filing', $filing['filing']) }}">{{ $filing['filing'] }}</a>
                @endforeach
            </div>
        </div>
    @endif

</section>