<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $article->title }} | The Daily Brief</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('news.css') }}" rel="stylesheet">
</head>
<body>
    <header class="masthead"><div class="topline"><div class="container d-flex justify-content-between py-2"><span>{{ now()->format('l, F j, Y') }}</span><span>Independent news &amp; perspectives</span></div></div><div class="container masthead-main"><a href="{{ route('articles.index') }}" class="brand">The Daily Brief<span>.</span></a><span class="masthead-tagline">Stories that matter, every day.</span></div><nav class="main-nav" aria-label="Main navigation"><div class="container"><a href="{{ route('articles.index') }}" class="nav-label">Home</a><a href="{{ route('articles.index') }}#latest" class="nav-label">Latest news</a><a href="{{ route('articles.index') }}#search-form" class="nav-label">Search</a></div></nav></header>
    <main class="container py-5"><div class="row justify-content-center"><article class="col-lg-9 col-xl-8">
        <a href="{{ route('articles.index') }}" class="story-link">&larr; Back to articles</a>
        <p class="eyebrow mt-5 mb-3">{{ $article->category->name }}</p>
        <h1 class="detail-title">{{ $article->title }}</h1>
        <p class="lead text-secondary mt-4 lh-base">{{ $article->summary }}</p>
        <div class="border-top border-bottom py-3 my-4 story-meta"><time datetime="{{ $article->published_at->toISOString() }}">{{ $article->published_at->format('F j, Y') }}</time> <span class="mx-2">/</span> The Daily Brief</div>
        @php
            $categoryImage = match (strtolower($article->category->name)) {
                'business' => 'business', 'technology' => 'technology', 'culture' => 'culture', 'sports' => 'sports', default => 'world',
            };
        @endphp
        <figure class="mb-4">
            <img src="{{ $article->thumbnail_url ?: asset('images/news/'.$categoryImage.'.png') }}" class="img-fluid w-100" alt="">
            @unless ($article->thumbnail_url)<figcaption class="small text-secondary mt-2">Illustration</figcaption>@endunless
        </figure>
        <div class="article-body">{{ $article->body }}</div>
        <div class="border-top mt-5 pt-4"><a href="{{ route('articles.index') }}" class="story-link">&larr; Back to all stories</a></div>
    </article></div></main>
    <footer class="site-footer py-5"><div class="container d-flex flex-wrap justify-content-between gap-3"><span class="brand fs-3">The Daily Brief<span>.</span></span><span class="small text-white-50">Independent news &amp; perspectives</span></div></footer>
</body>
</html>
