<?php

namespace App\Exceptions;

use Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Mail\ExceptionOccured;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Illuminate\Support\Facades\Mail;

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
     * @param \Exception $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        if ($this->shouldReport($exception)) {
            $this->sendEmail($exception); // sends an email
        }
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        run_action('exception', []);
        return parent::render($request, $exception);
    }

    public function sendEmail(Throwable $exception)
    {
        try {
            $e = FlattenException::create($exception);
            $handler = new HtmlErrorRenderer(true);
            $html = $handler->getBody($e);
            Mail::to('seyedmehdiarabi@gmail.com')->queue(new ExceptionOccured($html));
        } catch (Throwable $ex) {
            return 'error';
        }
    }
}
