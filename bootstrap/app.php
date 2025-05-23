<?php

use App\Http\Middleware\checkAllowToTakeAssessment;
use App\Http\Middleware\CheckNotVerifiedEmail;
use App\Http\Middleware\checkResultSubmitSession;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check.result.submit' => checkResultSubmitSession::class,
            'check.allow.take.assessment' => checkAllowToTakeAssessment::class,
            'not-verified' => CheckNotVerifiedEmail::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (QueryException $e) {
            return back()->withErrors(['error' => 'An unexpected error occurred while processing your request. Please try again later.']);
        });
    })->create();
