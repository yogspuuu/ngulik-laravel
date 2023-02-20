<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Services\ArticleService;
use App\Http\Requests\Article\FeedRequest;
use App\Http\Requests\Article\IndexRequest;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\UpdateRequest;
use App\Http\Requests\Article\DestroyRequest;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Article\ArticleCollection;

class ArticleController extends Controller
{
    protected User $user;
    protected Article $article;
    protected ArticleService $articleService;

    public function __construct(User $user, Article $article, ArticleService $articleService)
    {
        $this->user = $user;
        $this->article = $article;
        $this->articleService = $articleService;
    }

    public function index(IndexRequest $request): ArticleCollection
    {
        return $this->articleResponseCollection($this->article->getFiltered($request->validated()));
    }

    public function feed(FeedRequest $request): ArticleCollection
    {
        return $this->articleResponseCollection($this->article->getFiltered($request->validated()));
    }

    public function show(Article $article): ArticleResource
    {
        return $this->articleResponseJson($article);
    }

    public function store(StoreRequest $request): ArticleResource
    {
        $article = auth()->user()->articles()->create($request->validated()['article']);

        $this->syncTags($article);

        return $this->articleResponseJson($article);
    }

    public function update(Article $article, UpdateRequest $request): ArticleResource
    {
        $article->update($request->validated()['article']);

        $this->syncTags($article);

        return $this->articleResponseJson($article);
    }

    public function destroy(Article $article, DestroyRequest $request): void
    {
        $article->delete();
    }

    public function favorite(Article $article): ArticleResource
    {
        $article->users()->attach(auth()->id());

        return $this->articleResponseJson($article);
    }

    public function unfavorite(Article $article): ArticleResource
    {
        $article->users()->detach(auth()->id());

        return $this->articleResponseJson($article);
    }

    protected function syncTags(Article $article): void
    {
        $this->articleService->syncTags($article, $this->request->validated()['article']['tagList'] ?? []);
    }
}
