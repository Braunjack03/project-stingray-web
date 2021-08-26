<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Models\ErrorLog;
use App\Http\Controllers\Auth\AuthController;

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
            $data = [
                //'id'      => $this->createUniversalUniqueIdentifier(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ];
           
            $dataArr = [
                'file'           => $data['file'],
                'error_summary'  => 'Line '.$data['line'].' '.$data['message'],
                'log_trace'      => $e,
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" =>  \Carbon\Carbon::now(),
                ];
             
            ErrorLog::insert($dataArr);
        });
    }
}
