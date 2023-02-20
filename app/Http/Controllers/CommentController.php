<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\DestroyRequest;
use App\Http\Requests\Comment\StoreRequest;
use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Article;
use App\Models\Comment;

class CommentController extends Controller
{
    protected Comment $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function list(Article $article): CommentCollection
    {
        return $this->commentResponseCollection($article->comment);
    }

    public function store(Article $article, StoreRequest $request): CommentResource
    {
        $comment = $article->comments()->create(['body' => $request->comment['body'], 'user_id' => auth()->id()]);

        return $this->commentResponseJson($comment);
    }

    public function destroy(Article $article, Comment $comment, DestroyRequest $request): void
    {
        $comment->delete();
    }
}
