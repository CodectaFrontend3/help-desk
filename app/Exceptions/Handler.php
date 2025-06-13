<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Spatie\Permission\Exceptions\UnauthorizedException;

class Handler
{
    public static function handle(Throwable $exception, Request $request)
    {
        
        if ($request->expectsJson() || $request->is('api/*')) {
            if ($exception instanceof ValidationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos inválidos',
                    'errors' => $exception->errors(),
                    'error' => config('app.debug') ? $exception->getMessage() : null
                ], 422);
            }

            if ($exception instanceof AuthenticationException) {
                return response()->json([
                    'success' => false,
                    'message' => 'No autenticado',
                    'error' => config('app.debug') ? $exception->getMessage() : null
                ], 401);
            }

            if ($exception instanceof AuthorizationException || $exception instanceof UnauthorizedException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Acceso no autorizado',
                    'error' => config('app.debug') ? $exception->getMessage() : null
                ], 403);
            }

            if ($exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recurso no encontrado',
                    'error' => config('app.debug') ? $exception->getMessage() : null
                ], 404);
            }

            if ($exception instanceof MethodNotAllowedHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Método HTTP no permitido',
                    'error' => config('app.debug') ? $exception->getMessage() : null
                ], 405);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error' => config('app.debug') ? $exception->getMessage() : null
            ], 500);
        }
    }
}

