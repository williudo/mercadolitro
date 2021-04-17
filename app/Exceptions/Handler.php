<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $code = $exception->getCode();

        if (empty($code))
            $code = 500;

        $message = $exception->getMessage();

        if (stripos($message, 'The given data was invalid') !== false) {
            $code = 422;
            /** @var \Illuminate\Validation\ValidationException $e */
            $message = 'O dados enviados são inválidos.';
        }

        if (stripos($message, 'Unauthenticated.') !== false) {
            $code = 401;
            /** @var \Illuminate\Validation\ValidationException $e */
            $message = 'Não autenticado.';
        }

        if ($request->expectsJson()) {
            return response()->json([
                'error' =>  $message,
                'message' => method_exists($exception, 'errors') ? $exception->errors() : null,
            ], $code);

        }

        return parent::render($request, $exception);
    }
}
