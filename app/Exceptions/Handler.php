<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

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

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Exception|Throwable $e
     * @return Response
     * @throws Throwable
     */
    public function render($request, Exception|Throwable $e)
    {
        return $this->checkValidationException($request, $e);
    }

    /**
     * Check for validation exception.
     *
     * @param Request $request
     * @param Exception $e
     *
     * @return mixed
     * @throws Throwable
     */
    private function checkValidationException(Request $request, Exception $e)
    {
        if ($e instanceof ValidationException) {
            return response()->json([
                'code' => $e->status,
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], $e->status);
        }

        return parent::render($request, $e);
    }
}
