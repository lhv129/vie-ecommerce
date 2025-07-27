<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
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

    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        // Xử lý ValidationException
        $this->renderable(function (ValidationException $e, $request) {
            if ($request->is('api/*')) { // Kiểm tra nếu là API request
                return response()->json([
                    'status' => false,
                    'message' => 'Lỗi validate.',
                    'errors' => $e->errors(), // Lấy lỗi từ ValidationException
                ], Response::HTTP_UNPROCESSABLE_ENTITY); // 422 Unprocessable Entity
            }
        });

        // HÃY TẠO MỘT RENDERABLE CHO NotFoundHttpException
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tài nguyên không tồn tại.',
                    'data' => []
                ], Response::HTTP_NOT_FOUND);
            }
        });
    }
}
