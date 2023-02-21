<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Support\Facades\App;



class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $exception)
    {

        if ($request->expectsJson()) {
            return $this->handleJsonException($exception);
        }

        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated.'
            ], 401);
        }
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    private function handleJsonException($exception)
    {
        $statusCode = 500;
        $responses = [
            'status'  => false,
            'message' => App::environment() == 'production' ? 'Internal Server Error.' : $exception->getMessage(),
        ];

        /**
         * Laravel validation exception render.
         */
        if ($exception instanceof ValidationException) {
            $statusCode = 422;
            $errors = $exception->validator->errors();
            $msgbag = $errors;
            $errors = [];
            foreach ($msgbag->messages() as $key => $value) {
                $errors[] = ['attribute' => $key, 'text' => $value[0]];
            }
            $responses['message'] = $errors;
        }

        if (
            $exception instanceof NotFoundHttpException ||
            $exception instanceof ModelNotFoundException
        ) {
            $statusCode = 404;
            $responses['message'] = 'Not found.';
        }

        if (
            $exception instanceof AuthorizationException ||
            $exception instanceof AuthenticationException
        ) {
            $statusCode = 401;
            $responses['message'] = $exception->getMessage();
        }

        if (
            $exception instanceof AuthorizationException ||
            $exception instanceof AccessDeniedHttpException
        ) {
            $statusCode = Response::HTTP_FORBIDDEN;
            $responses['message'] = $exception->getMessage();
        }

        if (
            $exception instanceof MethodNotAllowedHttpException
        ) {
            $statusCode = Response::HTTP_METHOD_NOT_ALLOWED;
            $responses['message'] = $exception->getMessage();
        }

        return response()->json($responses, $statusCode);
    }
}
