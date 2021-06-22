<?php

namespace App\Exceptions;

use App\Traits\ApiResponder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponder;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? ApiResponder::error(strtoupper(UNAUTHENTICATED_DESCRIPTION), Response::HTTP_UNAUTHORIZED)
            : redirect()->guest($exception->redirectTo() ?? route('login'));
    }

    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            if ($exception instanceof HttpException) {
                $code = $exception->getStatusCode();
                $message = Response::$statusTexts[$code];
                return ApiResponder::error($message, $code);
            }

            if ($exception instanceof ModelNotFoundException) {
                $model = strtolower(class_basename($exception->getModel()));
                return ApiResponder::error(
                    strtoupper("DATA_NOT_FOUND_$model"),
                    Response::HTTP_NOT_FOUND
                );
            }

            if ($exception instanceof ValidationException) {
                $errors = $exception->validator->errors()->getMessages();
                return ApiResponder::error($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        return parent::render($request, $exception);
    }
}
