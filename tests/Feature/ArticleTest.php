<?php

use App\Models\Article;
use App\Models\Category;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

it('seeds categories and articles safely on repeat runs', function () {
    $this->seed(DatabaseSeeder::class);
    expect(Category::count())->toBeGreaterThanOrEqual(5)
        ->and(Article::count())->toBeGreaterThanOrEqual(20)
        ->and(Article::where('status', 'draft')->count())->toBeGreaterThan(0)
        ->and(Article::published()->count())->toBeGreaterThan(0)
        ->and(Article::where('status', 'published')->whereNull('published_at')->count())->toBe(0);
    $count = Article::count();
    $this->seed(DatabaseSeeder::class);
    expect(Article::count())->toBe($count);
});

it('creates articles with valid unique permalinks and relationships', function () {
    $category = Category::factory()->create();
    $articles = Article::factory()->count(2)->for($category)->create();
    expect($articles[0]->category->is($category))->toBeTrue()
        ->and($category->articles()->count())->toBe(2)
        ->and($articles[0]->permalink)->not->toBe($articles[1]->permalink)
        ->and($articles[0]->published_at)->not->toBeNull();
});

it('shows published articles and their details while hiding drafts and future articles', function () {
    $article = Article::factory()->for(Category::factory()->state(['name' => 'Science']))->create(['title' => 'A discovery', 'body' => 'The full story']);
    $draft = Article::factory()->draft()->create(['title' => 'Secret draft']);
    $future = Article::factory()->create(['title' => 'Future story', 'published_at' => now()->addDay()]);
    $this->get(route('articles.index'))->assertOk()->assertSee('A discovery')->assertSee('Science')->assertSee(route('articles.show', $article->permalink))->assertDontSee('Secret draft')->assertDontSee('Future story');
    $this->get(route('articles.show', $article->permalink))->assertOk()->assertSee('A discovery')->assertSee('The full story')->assertSee('Science');
    $this->get(route('articles.show', $draft->permalink))->assertNotFound();
    $this->get(route('articles.show', $future->permalink))->assertNotFound();
    $this->get('/articles/missing')->assertNotFound();
});

it('returns paginated published JSON with categories without per-article queries', function () {
    Article::factory()->count(12)->create();
    Article::factory()->draft()->create(['title' => 'Secret draft']);
    DB::flushQueryLog();
    DB::enableQueryLog();
    $response = $this->getJson('/api/articles');
    $queries = DB::getQueryLog();
    DB::disableQueryLog();
    $response->assertOk()->assertJsonCount(10, 'data')->assertJsonPath('meta.total', 12)->assertDontSee('Secret draft')->assertJsonStructure(['data' => [['title', 'summary', 'published_at', 'permalink', 'category' => ['id', 'name']]], 'links', 'meta']);
    expect(count($queries))->toBe(3);
    $this->getJson('/api/articles?page=2')->assertOk()->assertJsonCount(2, 'data');
});

it('searches all published articles case insensitively and paginates results', function () {
    Article::factory()->count(11)->create(['title' => 'Ocean report']);
    Article::factory()->create(['title' => 'Mountain report']);
    Article::factory()->draft()->create(['title' => 'Ocean draft']);
    $this->get('/articles?search=OCEAN')->assertOk()->assertSee('Ocean report')->assertDontSee('Mountain report')->assertDontSee('Ocean draft')->assertSee('page=2');
    $this->get('/articles?search=ocean&page=2', ['X-Requested-With' => 'XMLHttpRequest'])->assertOk()->assertJsonPath('html', fn ($html) => str_contains($html, 'Ocean report') && ! str_contains($html, 'Mountain report'));
    $this->get('/articles?search=missing')->assertOk()->assertSee('No articles found');
});

it('returns empty API results gracefully', function () {
    $this->getJson('/api/articles')->assertOk()->assertJsonCount(0, 'data')->assertJsonPath('meta.total', 0);
});
