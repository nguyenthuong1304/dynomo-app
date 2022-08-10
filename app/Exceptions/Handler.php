<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use ErrorException;
use Exception;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        dd('haha');

        $this->reportable(function (Throwable $e) {
            // $this->handleException($request, $e);
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        dd('haha');
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'status' => Response::HTTP_UNAUTHORIZED,
            'message' => $exception->getMessage(),
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function handleException($request, Exception $e)
    {
        switch ($e) {
            case $e instanceof RouteNotFoundException || $e instanceof NotFoundHttpException:
                return response()->json([
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => '404 Not Found',
                ], Response::HTTP_NOT_FOUND);
            case $e instanceof ModelNotFoundException:
                return response()->json([
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => __('messages.model_not_found'),
                ], Response::HTTP_NOT_FOUND);
            case $e instanceof AuthorizationException:
                return response()->json([
                    'status' => Response::HTTP_FORBIDDEN,
                    'message' => $e->getMessage(),
                ], Response::HTTP_FORBIDDEN);
            case $e instanceof AccessDeniedHttpException:
                return response()->json([
                    'status' => Response::HTTP_FORBIDDEN,
                    'message' => 'Bạn không có quyền!!',
                ], Response::HTTP_FORBIDDEN);
            case $e instanceof ErrorException:
                return response()->json([
                    'status' => $e->getCode(),
                    'data' => method_exists($e, 'getData') ? $e->getData() : null,
                    'message' => $e->getMessage(),
                ], $e->getCode());
            case $e instanceof QueryException:
                return response()->json([
                    'status' => 500,
                    'data' => [],
                    'messages' => $e->getMessage(),
                ]);
        }
    }
}
