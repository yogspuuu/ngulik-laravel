<?php

namespace App\Http\Controllers;

use App\Htpp\Resource\User\UserResource;
use App\Http\Resources\Article\ArticleCollection;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Profile\ProfileResouce;
use App\Http\Resources\Tag\TagCollection;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function articleResponseCollection(object $article): ArticleCollection
    {
        return new ArticleCollection($article);
    }

    public function articleResponseJson(Article $article): ArticleResource
    {
        $article = $article->load('user', 'users', 'tags', 'user.followers');
        return new ArticleResource($article);
    }

    public function commentResponseCollection(object $comment): CommentCollection
    {
        return new CommentCollection($comment);
    }

    public function commentResponseJson(Comment $comment): CommentResource
    {
        return new CommentResource($comment);
    }

    public function profileResponseJson(User $user): ProfileResouce
    {
        return new ProfileResouce($user);
    }

    public function tagResponseCollection(object $tag): TagCollection
    {
        return new TagCollection($tag);
    }

    protected function userResponseJson(string $jwtToken): UserResource
    {
        $user = auth()->user();
        $user->token = $jwtToken;

        return new UserResource($user);
    }
}
