<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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

        $this->renderable(function (Exception $e, Request $request) {
            if ($request->is('api/*') && $e->getCode() == 404) {
                return $this->handleNotFoundException($e);
            }
        });

        $this->renderable(function (Exception $e, Request $request) {
            if ($request->is('api/*') && $e->getCode() == 400) {
                return $this->handleBadRequest($e);
            }
        });

        $this->renderable(function (Exception $e, Request $request) {
            if ($request->is('api/*')  && $e->getCode() == 500) {
                return $this->handleInternalServerError($e);
            }
        });
    }

    protected function handleBadRequest(Exception $e): JsonResponse
    {
        Log::warning('Bad Request 400: '. $e->getMessage());
        return response()->json([
            'title' => 'Bad Request',
            'message' => $e->getMessage(),
            'code' => 400
        ], 400);
    }

    protected function handleInternalServerError(Exception $e): JsonResponse
    {
        Log::error('Internal Server Error 500: '. $e->getMessage());
        return response()->json([
            'title' => 'Internal Server Error',
            'code' => 500
        ], 500);
    }

    protected function handleNotFoundException(Exception $e): JsonResponse
    {
        Log::notice('Not Found 404: '. $e->getMessage());
        return response()->json([
            'title' => 'Not Found',
            'message' => $e->getMessage(),
            'code' => 404
        ], 404);
    }
}
