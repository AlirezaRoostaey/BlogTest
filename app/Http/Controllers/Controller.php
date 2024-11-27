<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

abstract class Controller
{
    protected function success($data = null, $message = null): JsonResponse
    {

        return Response::json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ]);
    }

    protected function error($data = null, $message = 'Something went wrong', $code = 400): JsonResponse
    {
//        return response()->json([
//            'status' => 'error',
//            'message' => $message,
//            'data' => $data,
//        ], $code);

        return Response::json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
