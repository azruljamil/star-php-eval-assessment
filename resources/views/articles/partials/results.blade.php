<div class="row g-4 editorial-grid">
    @forelse ($articles as $article)
        <div class="{{ $loop->first ? 'col-12 lead-story' : 'col-md-6' }}"><article class="news-card h-100 d-flex flex-column">
            <a href="{{ route('articles.show', $article->permalink) }}" tabindex="-1" aria-hidden="true">
                @php
                    $categoryImage = match (strtolower($article->category->name)) {
                        'business' => 'business', 'technology' => 'technology', 'culture' => 'culture', 'sports' => 'sports', default => 'world',
                    };
                @endphp
                <img src="{{ $article->thumbnail_url ?: asset('images/news/'.$categoryImage.'.png') }}" class="story-image" alt="">
            </a>
            <div class="eyebrow mt-4 mb-2">{{ $article->category->name }}</div>
            <h3 class="story-title"><a href="{{ route('articles.show', $article->permalink) }}">{{ $article->title }}</a></h3>
            <p class="story-summary">{{ $article->summary }}</p>
            <div class="mt-auto d-flex justify-content-between align-items-center gap-3 pt-2"><time class="story-meta" datetime="{{ $article->published_at->toISOString() }}">{{ $article->published_at->format('M j, Y') }}</time><a class="story-link" href="{{ route('articles.show', $article->permalink) }}">Read story &rarr;</a></div>
        </article></div>
    @empty
        <div class="col-12"><div class="border-top py-5"><h3 class="section-title">No articles found.</h3><p class="text-secondary">Try another search or clear the search field.</p></div></div>
    @endforelse
</div>
<div class="pagination-container mt-5">{{ $articles->links('pagination::bootstrap-5') }}</div>
