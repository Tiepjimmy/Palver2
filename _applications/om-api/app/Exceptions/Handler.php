<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;
use Exception;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
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
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
//    public function report(Throwable $exception)
//    {
//        parent::report($exception);
//    }

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
        if ($this->isHttpException($exception)) {
            switch ($exception->getStatusCode()) {
                case '400':
                    return response()->responseError('Bad Request', array(), 400);
                    break;
                case '403':
                    return response()->responseError('Forbidden', array(), 403);
                    break;
                case '404':
                    return response()->responseError('Not Found', array(), 404);
                    break;
                case '500':
                    return response()->responseError('Internal Server Error', array(), 500);
                    break;
                case '503':
                    return response()->responseError('Service Unavailable', array(), 503);
                    break;
                default:
                    return $this->renderHttpException($exception);
                    break;
            }
        } else {
            return parent::render($request, $exception);
        }
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errorResults = array();
        $errors = $e->validator->errors()->getMessages();
        foreach ($errors as $errorKey => $error) {
            $errorResults[$errorKey] = is_array($error) ? $error[0] : $error;
        }
        return response()->responseError($errorResults);
    }

    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception) {
        return $request->expectsJson() ? response()->json([
            "status_code" => 401,
            "success" => false,
            'message' => $exception->getMessage()
        ], 401) : redirect()->route('login');
    }
}
