<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\UserResource;
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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user;
    protected $message;

    public function __construct(User $user)
    {
        $message = config('constant.messages');
        $this->message = $message;
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

    protected function userResponseJson(string $jwtToken): JsonResponse
    {
        $user = auth()->user();
        $user->token = $jwtToken;
        $data = new UserResource($user);

        return $this->success($data, $this->message);
    }

    protected function success($data = null, $message = null, $status = true, $pagination = null)
    {
        $responses = [
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'pagination' => $pagination
        ];

        return response()->json($responses, Response::HTTP_OK);
    }
}
