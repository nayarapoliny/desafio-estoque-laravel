<?php

use App\Support\ApiResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (HttpResponseException $exception) {
            return $exception->getResponse();
        });

        $exceptions->render(function (ValidationException $exception) {
            return ApiResponse::error(
                'Erro de validacao.',
                422,
                $exception->errors()
            );
        });

        $exceptions->render(function (NotFoundHttpException $exception) {
            return ApiResponse::error('Recurso nao encontrado.', 404);
        });

        $exceptions->render(function (HttpExceptionInterface $exception) {
            return ApiResponse::error(
                $exception->getMessage() ?: 'Erro na requisicao.',
                $exception->getStatusCode()
            );
        });
    })->create();
