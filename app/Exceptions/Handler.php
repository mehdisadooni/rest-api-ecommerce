<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\DB;
use Throwable;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {

            DB::rollBack();
            return errorResponse($e->getMessage(), 404);
        }
        if ($e instanceof NotFoundHttpException) {
            DB::rollBack();
            return errorResponse($e->getMessage(), 404);
        }
        if ($e instanceof MethodNotAllowedHttpException) {
            DB::rollBack();
            return errorResponse($e->getMessage(), 500);
        }
        if ($e instanceof \Exception) {
            DB::rollBack();
            return errorResponse($e->getMessage(), 500);
        }
        if ($e instanceof \Error) {
            DB::rollBack();
            return errorResponse($e->getMessage(), 500);
        }
        if ($e instanceof \ErrorException) {
            DB::rollBack();
            return errorResponse($e->getMessage(), 500);
        }
        if ($e instanceof QueryException) {
            DB::rollBack();
            return errorResponse($e->getMessage(), 500);
        }

        if (config('app.debug')) {
            return parent::render($request, $e);
        }

        DB::rollBack();
        return errorResponse($e->getMessage(), 500);
    }

}
