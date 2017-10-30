<section class="blog-left-section text-right">
    <div class="avatar">
        <a href="/"><img src="{{ config('app.storage_host') }}/storage/images/avatar.jpeg" width="80" alt="avatar"></a>
    </div>
    <div class="blog-introduce blog-nav">
        <h4>Simon Fu's Blog</h4>
        <i>Stay hungry, stay foolish!</i>
        <div class="menus">
            @foreach($catalogs as $catalog)
                <a href="{{ url($catalog -> action) }}">{{ $catalog -> name }}</a>
                {{--<a href="/about">About me</a>--}}
                {{--<a href="/daily">日常</a>--}}
            @endforeach
        </div>
        <hr>
    </div>

    @if(!is_null($categories))
        <div class="blog-categories blog-nav">
            <h3>Categories</h3>
            @foreach($categories as $category)
                <a href="{{ url('category', $category -> id) }}">{{ $category -> name }}</a>
            @endforeach
        </div>
    @endif
    @if(!is_null($filings))
        <div class="blog-categories blog-nav">
            <div class="blog-filing blog-nav">
                <h3>Filing</h3>
                @foreach($filings as $filing)
                    <a href="{{ url('filing', $filing -> filing) }}">{{ $filing -> filing }}</a>
                @endforeach
            </div>
        </div>
    @endif

</section>