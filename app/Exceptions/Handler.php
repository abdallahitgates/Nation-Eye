<?php

namespace App\Exceptions;

use App\Http\Traits\Api_Trait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use Api_Trait;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception)
    {
        // if (app()->environment('local')) {
        //     // If we're in local environment, show detailed error messages in the response
        //     return parent::render($request, $exception);
        // }

        // mobile team need status to be 200
        if ($request->expectsJson()) {
            $exception->status = 200;
        }

        if ($exception instanceof BalaghatException) {
            return $this->respond($exception->getData(), 'error', 422);
        }
        if ($exception instanceof ValidationException) {
            $error_message = $exception->validator->errors()->first();
            return $this->respondWithErrorMessage($error_message, 200);
        }

        if ($exception instanceof QueryException) {
            // $sql =  $exception->getSql();
            // $message=$sql.' ';
            $message = $exception->getMessage();
            $bindings =  $exception->getBindings();
            return $this->respondWithErrorMessage($message, 422);
        }
        if ($exception instanceof AuthenticationException) {
            return $this->respondWithErrorMessage('Unauthenticated', 200);
        }
        if ($exception instanceof AuthorizationException) {
            return $this->respondWithErrorMessage($exception->getMessage(), 200);
        }
        if ($exception instanceof NotFoundHttpException) {
            return $this->respondWithErrorMessage('The requested URL could not be retrieved.', 404);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->respondWithErrorMessage('The specified method for the request is invalid .', 404);
        }
        return parent::render($request, $exception);

        // For other environments, return a generic error message
        //     return response()->json([
        //         'message' => 'Something went wrong. Please try again later.',
        //         'error' => $exception->getMessage(),
        //     ], 500);
    }
}
