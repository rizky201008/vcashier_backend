<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
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
        // Custom JSON response for exceptions
        return response()->json([
            'message' => $exception->getMessage(),
            'status' => $this->getStatusCode($exception),
            'data' => null
        ], $this->getStatusCode($exception));
    }

    /**
     * Get the status code for the exception.
     */
    protected function getStatusCode(Throwable $exception): int
    {
        // If exception has a specific HTTP status code, return it
        if (method_exists($exception, 'getStatusCode')) {
            return $exception->getStatusCode();
        }

        // Default to 500 (Internal Server Error) if no status code is provided
        return 500;
    }
}
