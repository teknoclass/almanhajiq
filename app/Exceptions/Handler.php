<?php
namespace App\Exceptions;

use App\Http\Response\ErrorResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
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
        $this->reportable(function(Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        /* if ($request->is('api/*')) {

            if ($e instanceof ApiException) {
                Log::error($e->getMessage());
                return $e->render();
            }
            elseif ($e instanceof ValidationException) {
                $exception = new ApiValidationException(__('message.validation_exception'), Response::HTTP_BAD_REQUEST);
                return $exception->render($e->errors());
            }
            elseif ($e instanceof AuthenticationException) {
                $exception = new ApiAuthException($e->getMessage(), Response::HTTP_UNAUTHORIZED);
                return $exception->render();
            }
            elseif ($e instanceof AuthorizationException || $e instanceof UnauthorizedException) {
                $exception = new ApiAuthException($e->getMessage(), Response::HTTP_UNAUTHORIZED);
                return $exception->render();
            }
            elseif ($e instanceof ModelNotFoundException) {
                $exception = new ApiAuthException(__('message.model_not_found'), Response::HTTP_NOT_FOUND);
                return $exception->render();
            }

            return response()->json(
                new ErrorResponse('Internal Server Error', Response::HTTP_INTERNAL_SERVER_ERROR),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        } */

        // For non-API routes, use the default handling
        return parent::render($request, $e);
    }


    /**
     * @param Throwable $e
     *
     * @return void
     */
    public function report(Throwable $e)
    {
        if ($e instanceof ApiException || $e instanceof ValidationException) {
            return;
        }

        if (config('app.debug')) {
            Log::error(
                sprintf(
                    "type: %s\nmessage: %s\nin file: %s line:%d\n",
                    get_class($e),
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getLine()
                )
            );
        }
    }
}
