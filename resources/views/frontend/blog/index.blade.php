@extends('layouts.layouts')
@section('body')
    <div class="blog-main">
        <div class="col-md-3 col-sm-3 col-lg-2">
            <section class="blog-left-section text-right">
                <div class="avatar">
                    <img src="/storage/images/avatar.jpeg" width="80" alt="avatar">
                </div>
                <div class="blog-introduce blog-nav">
                    <h4>Simon Fu's Blog</h4>
                    <i>Stay hungry, stay foolish!</i>
                    <div class="menus">
                        <a href="/about">About me</a>
                        <a href="/timeline">Time-line</a>
                        <a href="/techless">技术无关</a>
                    </div>
                    <hr>
                </div>

                <div class="blog-categories blog-nav">
                    <h3>Categories</h3>
                    <a href="/blog/category/1">PHP</a>
                    <a href="/blog/category/1">Python</a>
                    <a href="/blog/category/1">HTML</a>
                </div>
                <div class="blog-tags blog-nav">
                    <h3>Tags</h3>

                    <a class="btn btn-xs btn-primary" type="button" href="/tag/2">
                        PHP <span class="badge">2</span>
                    </a>
                    <a class="btn btn-xs btn-success" type="button" href="/tag/2">
                        PHP <span class="badge">2</span>
                    </a>
                    <a class="btn btn-xs btn-info" type="button" href="/tag/2">
                        PHP <span class="badge">2</span>
                    </a>
                    <a class="btn btn-xs btn-warning" type="button" href="/tag/2">
                        PHP <span class="badge">2</span>
                    </a>
                    <a class="btn btn-xs btn-info" type="button" href="/tag/2">
                        PHP <span class="badge">2</span>
                    </a>
                    <a class="btn btn-xs btn-danger" type="button" href="/tag/2">
                        PHP <span class="badge">2</span>
                    </a>
                    <a class="btn btn-xs btn-danger" type="button" href="/tag/2">
                        PHP <span class="badge">2</span>
                    </a>
                    <a class="btn btn-xs btn-danger" type="button" href="/tag/2">
                        PHP <span class="badge">2</span>
                    </a>
                </div>
            </section>
        </div>
        <div class="col-md-9 col-sm-9 col-lg-10">
            <section class="blog-right-section">
                <div class="jumbotron blog-category-header">
                    <div class="blog-categories-header">
                        <h3><code>echo 'Hello, world!';</code></h3>
                    </div>
                </div>
                <div class="blog-archives">
                    <div class="blog-archive-block">
                        <div class="blog-archive-title">
                            <h2>Title</h2>
                        </div>
                        <div class="blog-archive-content">
                            <span>dsadsadsa</span>
                        </div>
                        <div class="blog-archive-read-more">
                            <a href="">Read more</a>
                        </div>
                        <div class="blog-archive-category-and-publish text-right">
                            <i>in PHP | <span class="numbers">2017-08-31</span></i>
                        </div>
                    </div>
                    <div class="blog-archive-block">
                        <div class="blog-archive-title">
                            <h2>Title</h2>
                        </div>
                        <div class="blog-archive-content">
                            <span>dsadsadsa</span>
                        </div>
                        <div class="blog-archive-read-more">
                            <a href="">Read more</a>
                        </div>
                        <div class="blog-archive-category-and-publish text-right">
                            <i>in PHP | <span class="numbers">2017-08-31</span></i>
                        </div>
                    </div>
                    <div class="blog-archive-block">
                        <div class="blog-archive-title">
                            <h2>Title</h2>
                        </div>
                        <div class="blog-archive-content">
                            <span>dsadsadsa</span>
                        </div>
                        <div class="blog-archive-read-more">
                            <a href="">Read more</a>
                        </div>
                        <div class="blog-archive-category-and-publish text-right">
                            <i>in PHP | <span class="numbers">2017-08-31</span></i>
                        </div>
                    </div>
                    <div class="blog-archive-block">
                        <div class="blog-archive-title">
                            <h2>Title</h2>
                        </div>
                        <div class="blog-archive-content">
                            <span>dsadsadsa</span>
                        </div>
                        <div class="blog-archive-read-more">
                            <a href="">Read more</a>
                        </div>
                        <div class="blog-archive-category-and-publish text-right">
                            <i>in PHP | <span class="numbers">2017-08-31</span></i>
                        </div>
                    </div>
                    <div class="blog-archive-block">
                        <div class="blog-archive-title">
                            <h2>Title</h2>
                        </div>
                        <div class="blog-archive-content">
                            <span>dsadsadsa</span>
                        </div>
                        <div class="blog-archive-read-more">
                            <a href="">Read more</a>
                        </div>
                        <div class="blog-archive-category-and-publish text-right">
                            <i>in PHP | <span class="numbers">2017-08-31</span></i>
                        </div>
                    </div>
                </div>

                <section class="blog-pagination text-right">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li>
                                <a href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li>
                                <a href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </section>
            </section>
        </div>
    </div>
    @include('layouts.footer')
@endsection
