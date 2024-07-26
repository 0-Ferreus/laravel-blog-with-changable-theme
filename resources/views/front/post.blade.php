@extends('layouts.' . $app)

@section('content')
    @php
        use Illuminate\Support\Str;
        use Carbon\Carbon;
    @endphp
    <!-- Page content-->
    <div class="container mt-5">
        <div class="row" id="body">
            <div class="col-lg-8" id="article">
                <!-- Post content-->
                <article>
                    <!-- Post header-->
                    <header class="mb-4">
                        <!-- Post title-->
                        <h1 class="fw-bolder mb-1">{{ $article->title }}</h1>
                        <!-- Post meta content-->
                        <div class="text-muted fst-italic mb-2">Posted on
                            {{ Carbon::parse($article->created_at)->format('d M, Y') }}</div>
                        <!-- Post categories-->
                        <a class="badge bg-secondary text-decoration-none link-light" href="#!">{{ $category->name }}</a>
                    </header>
                    <!-- Preview image figure-->
                    <figure class="mb-4"><img class="img-fluid rounded" style="width: 900px;height:400px;object-fit:cover"
                            src="{{ asset('images/' . $article->image) }}" alt="..." /></figure>
                    <!-- Post content-->
                    <section class="mb-5">
                        <p class="fs-5 mb-4">{!! $article->body !!}</p>
                    </section>
                </article>
                {{-- <!-- Comments section-->
                    <section class="mb-5">
                        <div class="card bg-light">
                            <div class="card-body">
                                <!-- Comment form-->
                                <form class="mb-4"><textarea class="form-control" rows="3" placeholder="Join the discussion and leave a comment!"></textarea></form>
                                <!-- Comment with nested comments-->
                                <div class="d-flex mb-4">
                                    <!-- Parent comment-->
                                    <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                                    <div class="ms-3">
                                        <div class="fw-bold">Commenter Name</div>
                                        If you're going to lead a space frontier, it has to be government; it'll never be private enterprise. Because the space frontier is dangerous, and it's expensive, and it has unquantified risks.
                                        <!-- Child comment 1-->
                                        <div class="d-flex mt-4">
                                            <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                                            <div class="ms-3">
                                                <div class="fw-bold">Commenter Name</div>
                                                And under those conditions, you cannot establish a capital-market evaluation of that enterprise. You can't get investors.
                                            </div>
                                        </div>
                                        <!-- Child comment 2-->
                                        <div class="d-flex mt-4">
                                            <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                                            <div class="ms-3">
                                                <div class="fw-bold">Commenter Name</div>
                                                When you put money directly to a problem, it makes a good headline.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single comment-->
                                <div class="d-flex">
                                    <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                                    <div class="ms-3">
                                        <div class="fw-bold">Commenter Name</div>
                                        When I look at the universe and all the ways the universe wants to kill us, I find it hard to reconcile that with statements of beneficence.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section> --}}
            </div>
            <!-- Side widgets-->
            <div class="col-lg-4" id="side-widgets">
                <!-- Search widget-->
                <div class="card mb-4" id="search">
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
                <div class="card mb-4" id="categories">
                    <div class="card-header">Categories</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <ul class="list-unstyled mb-0">
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($categories as $category)
                                            <li><a class="nav-link m-2" href="#!">{{ $category->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Side widget-->
                <div class="card mb-4" id="latest-posts">
                    <div class="card-header">Latest Posts</div>
                    <div class="card-body">

                        @foreach ($articles as $article)
                            <div class="card mb-4 indiv-card" >
                                <a class="nav-link" href="{{ route('show', $article->id) }}">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="me-3 col-4" style="">
                                                <img class="img-fluid rounded w-100" style="height:100px;object-fit:cover"
                                                    src="{{ asset('images/' . $article->image) }}" alt="..." />
                                            </div>
                                            <div class="">
                                                <span
                                                    style="border-bottom: 1px solid black"><b>{{ $article->title }}</b></span>
                                                <br>
                                                <span
                                                    class="fs-6">{{ Carbon::parse($article->created_at)->format('d M, Y') }}</span>
                                            </div>
                                        </div>
                                </a>
                            </div>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')

@if($script != 1)
<script src="{{ asset('assets/js/' . $script . '.js') }}"></script>
@endif

@endsection
