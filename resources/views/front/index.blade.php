@extends('layouts.' . $app)


@section('content')
    <!-- Page header with logo and tagline-->
    <header class="py-5 bg-light border-bottom mb-4">
        <div class="container">
            <div class="text-center my-5">
                <h1 class="fw-bolder">Welcome to Blog Home!</h1>
                <p class="lead mb-0">A Bootstrap 5 starter layout for your next blog homepage</p>
            </div>
        </div>
    </header>
    <!-- Page content-->
    <div class="container">
        <div class="row">
            <!-- Blog entries-->
            <div class="col-lg-8">
                <!-- Featured blog post-->
                <div class="card mb-4">
                    <a href="#!"><img class="card-img-top" src="{{ asset('images/' . $latest->image) }}"
                            alt="..." style="width: 100%; height:350px; object-fit:cover" /></a>
                    @php
                        use Illuminate\Support\Str;
                        use Carbon\Carbon;
                    @endphp
                    <div class="card-body">
                        <div class="small text-muted">{{ Carbon::parse($latest->created_at)->format('d M, Y') }}</div>
                        <h2 class="card-title">{{ $latest->title }}</h2>
                        <p class="card-text">{{ Str::words(strip_tags($latest->body), 50, '...') }}</p>
                        <a class="btn btn-primary" href="{{ route('show', $latest->id) }}">Read more →</a>
                    </div>
                </div>
                {{-- {{ Str::words(strip_tags($article->body), 30, '...') }} --}}
                <!-- Nested row for non-featured blog posts-->
                <div class="row">
                    @foreach($articles as $article)
                        <div class="col-lg-6 mb-4">
                            <!-- Blog post -->
                            <div class="card" style="height: 500px">
                                <a href="{{ route('show', $article->id) }}">
                                    <img class="card-img-top" src="{{ asset('images/' . $article->image) }}" alt="{{ $article->title }}" style="width: 100%; height: 250px; object-fit: cover;">
                                </a>
                                <div class="card-body">
                                    <div class="small text-muted">
                                        {{ \Carbon\Carbon::parse($article->created_at)->format('d M, Y') }}
                                    </div>
                                    <div class="mb-2" style="max-height: 140px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-box-orient: vertical;">
                                    <h2 class="card-title h4">{{ $article->title }}</h2>
                                    <p class="card-text">
                                        {{strip_tags($article->body)}}
                                    </p>
                                    </div>
                                    <a class="btn btn-primary" href="{{ route('show', $article->id) }}">Read more →</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Pagination-->
                <nav aria-label="Pagination">
                    <hr class="my=0">
                    {{ $articles->links('pagination-custom') }}
                </nav>
            </div>
            <!-- Side widgets-->
            <div class="col-lg-4">
                <!-- Search widget-->
                <div class="card mb-4">
                    <div class="card-header">Search</div>
                    <div class="card-body">
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Enter search term..."
                                aria-label="Enter search term..." aria-describedby="button-search" />
                            <button class="btn btn-primary" id="button-search" type="button">Go!</button>
                        </div>
                    </div>
                </div>
                <!-- Categories widget-->
                <div class="card mb-4">
                    <div class="card-header">Categories</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <ul class="list-unstyled mb-0">
                                    @foreach($categories as $category)
                                    <li><a class="nav-link m-2" href="#!">{{$category->name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Side widget-->
                <div class="card mb-4">
                    <div class="card-header">Side Widget</div>
                    <div class="card-body">You can put anything you want inside of these side widgets. They are easy to
                        use, and feature the Bootstrap 5 card component!</div>
                </div>
            </div>
        </div>
    </div>

@endsection
