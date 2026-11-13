<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $search = trim((string) $request->query('search', ''));
        $articles = Article::published()->with('category')
            ->when($search !== '', fn ($query) => $query->whereRaw('LOWER(title) LIKE ?', ['%'.mb_strtolower($search).'%']))
            ->orderByDesc('published_at')->orderByDesc('id')->paginate(9)->withQueryString();
        if ($request->ajax()) {
            return response()->json(['html' => view('articles.partials.results', compact('articles'))->render()]);
        }

        return view('articles.index', compact('articles', 'search'));
    }

    public function show(string $permalink): View
    {
        $article = Article::published()->with('category')->where('permalink', $permalink)->firstOrFail();

        return view('articles.show', compact('article'));
    }

    public function apiIndex(): AnonymousResourceCollection
    {
        return ArticleResource::collection(Article::published()->with('category')->orderByDesc('published_at')->orderByDesc('id')->paginate(10));
    }
}
