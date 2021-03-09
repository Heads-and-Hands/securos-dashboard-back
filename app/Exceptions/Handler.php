<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
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
     * @throws \Exception
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
        if ($request->isJson() || strpos($request->getRequestUri(), '/api/') !== false) {
            return $this->handleApiException($request, $exception);
        }
        return parent::render($request, $exception);
    }

    private function handleApiException($request, Throwable $exception)
    {
        $exception = $this->prepareException($exception);
        if ($exception instanceof \Illuminate\Http\Exceptions\HttpResponseException) {
            $exception = $exception->getResponse();
        }
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
        }
        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            return $this->invalidJson($request, $exception);
        }

        return $this->customApiResponse($exception);
    }


    private function customApiResponse($exception)
    {
        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }
        $response['data'] = null;
        switch ($statusCode) {
            case 401:
                $response['message'] = 'Unauthorized';
                break;
            case 403:
                $response['message'] = $exception->getMessage() ? $exception->getMessage() : 'Forbidden';
                break;
            case 404:
                $response['message'] = 'Not Found';
                break;
            case 405:
                $response['message'] = 'Method Not Allowed';
                break;
            case 422:
                $response['message'] = $exception->original['message'] ?? $exception->getMessage();
                $response['errors'] = $exception->original['errors'] ?? null;
                break;
            default:
                $response['errors'] = $exception->getMessage();
                break;
        }

        $response['code'] = $statusCode;

        if (config('app.debug')) {
            $response['trace'] = $exception->getTrace();
        }

        return response($response, $statusCode);
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json(
            [
                'data' => null,
                'message' => $exception->getMessage(),
                'errors' => $exception->errors(),
                'code' => 1,
            ],
            $exception->status
        );
    }
}
