<?php

namespace App\Exceptions;

use App\Traits\HttpResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use League\Container\Exception\NotFoundException;
use Psy\Exception\TypeErrorException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use TypeError;

class Handler extends ExceptionHandler
{
    use HttpResponse;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            return $this->error(
                'The resource was not found in the database',
                Response::HTTP_NOT_FOUND
            );
        }

        if ($e instanceof AuthorizationException) {
            return $this->error(
                'You are not authorized to access this resource',
                Response::HTTP_FORBIDDEN
            );
        }

        if ($e instanceof NotFoundException) {
            return $this->error(
                'The resource was not found or the route is not defined',
                Response::HTTP_NOT_FOUND
            );
        }

        if ($e instanceof TypeError || $e instanceof TypeErrorException){
            return $this->error(
                'The type of the parameter is not the expected one',
                Response::HTTP_BAD_REQUEST
            );
        }

        return parent::render($request, $e);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
