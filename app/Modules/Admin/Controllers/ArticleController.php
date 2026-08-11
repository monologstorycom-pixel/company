<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ArticleTag;
use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct(
        protected ArticleService $articleService
    ) {}

    public function index(Request $request)
    {
        $this->authorize('view articles');

        $filters = [
            'search' => $request->input('search'),
            'status' => $request->input('status'),
            'category' => $request->input('category'),
        ];

        $articles = $this->articleService->getPaginated($filters, 15);
        $categories = ArticleCategory::orderBy('name')->get();
        
        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $this->authorize('create articles');

        $categories = ArticleCategory::all();
        $tags = ArticleTag::all();
        return view('admin.articles.create', compact('categories', 'tags'));
    }

    public function store(StoreArticleRequest $request)
    {
        try {
            $data = $request->validated();
            
            // Normalize category_id field name
            if (isset($data['article_category_id'])) {
                $data['category_id'] = $data['article_category_id'];
                unset($data['article_category_id']);
            }

            $tags = $data['tags'] ?? null;
            unset($data['tags']);

            $featuredImage = $request->hasFile('featured_image') ? $request->file('featured_image') : null;

            $this->articleService->create($data, $tags, $featuredImage);

            return redirect()->route('admin.articles.index')
                ->with('success', 'Article created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create article: ' . $e->getMessage());
        }
    }

    public function show(Article $article)
    {
        $this->authorize('view articles');

        $article->load(['category', 'author', 'tags']);
        return view('admin.articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $this->authorize('edit articles');

        $categories = ArticleCategory::all();
        $tags = ArticleTag::all();
        $article->load('tags');
        return view('admin.articles.edit', compact('article', 'categories', 'tags'));
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        try {
            $data = $request->validated();
            
            // Normalize category_id field name
            if (isset($data['article_category_id'])) {
                $data['category_id'] = $data['article_category_id'];
                unset($data['article_category_id']);
            }

            $tags = $data['tags'] ?? null;
            unset($data['tags']);

            $featuredImage = $request->hasFile('featured_image') ? $request->file('featured_image') : null;

            $this->articleService->update($article->id, $data, $tags, $featuredImage);

            return redirect()->route('admin.articles.index')
                ->with('success', 'Article updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update article: ' . $e->getMessage());
        }
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete articles');

        try {
            $this->articleService->delete($article->id, true);

            return redirect()->route('admin.articles.index')
                ->with('success', 'Article deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete article: ' . $e->getMessage());
        }
    }
}