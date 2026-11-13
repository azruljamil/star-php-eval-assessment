<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Latest News | The Daily Brief</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('news.css') }}" rel="stylesheet">
</head>
<body>
    <header class="masthead">
        <div class="topline"><div class="container d-flex justify-content-between py-2"><span>{{ now()->format('l, F j, Y') }}</span><span>Independent news &amp; perspectives</span></div></div>
        <div class="container masthead-main"><a href="{{ route('articles.index') }}" class="brand">The Daily Brief<span>.</span></a><span class="masthead-tagline">Stories that matter, every day.</span></div>
        <nav class="main-nav" aria-label="Main navigation"><div class="container"><a href="{{ route('articles.index') }}" class="nav-label">Home</a><a href="#latest" class="nav-label">Latest news</a><a href="#search-form" class="nav-label">Search</a></div></nav>
    </header>
    <main class="container pb-5">
        <div class="news-ticker"><span>Latest</span><p>News and perspectives to help you make sense of the world around you.</p></div>
        <div class="row g-5 py-4 py-lg-5">
            <section id="latest" class="col-lg-8">
                <div class="section-heading mb-4"><h1 class="section-title mb-0">Latest News</h1><span class="story-meta">The daily edition</span></div>
                <div id="results" aria-live="polite">@include('articles.partials.results')</div>
                <p id="search-error" class="text-danger mt-3" role="alert" hidden>Unable to load articles. Please try again.</p>
            </section>
            <aside class="col-lg-4">
                <div class="search-box p-4"><p class="eyebrow mb-2">Explore the news</p><h2 class="h3">Find a story</h2><p class="text-secondary small lh-lg">Search the latest articles by title.</p>
                    <form id="search-form" action="{{ route('articles.index') }}" method="get"><label for="article-search" class="form-label small fw-semibold">Search by title</label><div class="input-group"><input id="article-search" name="search" value="{{ $search }}" class="form-control" type="search" placeholder="Search articles..." autocomplete="off"><button type="submit" class="btn btn-news">Search</button></div><button id="clear-search" type="button" class="btn btn-link text-secondary px-0 small">Clear search</button></form>
                </div>
                <div class="sidebar-note mt-4"><p class="eyebrow">The Daily Brief</p><h2>Stay curious.</h2><p>Independent news and perspectives for a clearer view of the world.</p></div>
            </aside>
        </div>
    </main>
    <footer class="site-footer py-5"><div class="container d-flex flex-wrap justify-content-between gap-3"><span class="brand fs-3">The Daily Brief<span>.</span></span><span class="small text-white-50">Independent news &amp; perspectives</span></div></footer>

    <script>
        const form = document.getElementById('search-form');
        const input = document.getElementById('article-search');
        const results = document.getElementById('results');
        const error = document.getElementById('search-error');
        let timer, pending, requestNumber = 0;
        async function loadResults(url) {
            const current = ++requestNumber;
            if (pending) pending.abort();
            pending = new AbortController();
            try {
                const response = await fetch(url, {headers: {'X-Requested-With': 'XMLHttpRequest'}, signal: pending.signal});
                if (!response.ok) throw new Error('Request failed');
                const data = await response.json();
                if (current !== requestNumber) return;
                results.innerHTML = data.html;
                error.hidden = true;
                history.replaceState(null, '', url);
            } catch (exception) {
                if (exception.name !== 'AbortError') error.hidden = false;
            }
        }
        function search() {
            const url = new URL(form.action);
            if (input.value.trim()) url.searchParams.set('search', input.value.trim());
            loadResults(url);
        }
        input.addEventListener('input', () => { clearTimeout(timer); timer = setTimeout(search, 250); });
        form.addEventListener('submit', (event) => { event.preventDefault(); clearTimeout(timer); search(); });
        document.getElementById('clear-search').addEventListener('click', () => { input.value = ''; clearTimeout(timer); search(); input.focus(); });
        results.addEventListener('click', (event) => {
            const link = event.target.closest('.pagination a');
            if (link) { event.preventDefault(); clearTimeout(timer); loadResults(link.href); }
        });
    </script>
</body>
</html>
