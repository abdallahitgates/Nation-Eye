<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

trait Api_Trait
{

    public function getCurrentLang()
    {
        return app()->getLocale();
    }

    public function returnError($message, $status = 400)
    {
        return response()->json([
            'data' => null,
            'message' => is_array($message) || $message instanceof Collection ? $message[0] : $message,
            'status' => $status,
        ], 200);
    }

    public function returnErrorValidation($message, $status = 403)
    {
        return response()->json([
            'data' => null,
            'message' => is_array($message) || $message instanceof Collection ? $message[0] : $message,
            'status' => $status,
        ], 200);
    }

    public function returnErrorNotFound($message, $status = 404)
    {
        return response()->json([
            'data' => null,
            'message' => is_array($message) || $message instanceof Collection ? $message[0] : $message,
            'status' => $status,
        ], 200);
    }



    public function returnDataPaginate($data, $message, $last_page = null, $current_page = null, $total, $status = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => is_array($message) || $message instanceof Collection ? $message[0] : $message,
            'last_page' => $last_page,
            'current_page' => $current_page,
            'total' => $total,
            'status' => $status,
        ], 200);
    }

    public function returnData($data, $message, $status = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => is_array($message) || $message instanceof Collection ? $message[0] : $message,
            'status' => $status,
        ], 200);
    }


    public function returnSuccessMessage($message, $status = 200)
    {
        return response()->json([
            'data' => null,
            'message' => is_array($message) || $message instanceof Collection ? $message[0] : $message,
            'status' => $status,
        ], 200);
    }


    public function returnSuccessDataMessage($message, $status = 200)
    {
        return response()->json([
            'data' => (object) [],
            'message' => is_array($message) || $message instanceof Collection ? $message[0] : $message,
            'status' => $status,
        ], 200);
    }

    public function returnErrorDataNotFound($message, $status = 404)
    {
        return response()->json([
            'data' => (object) [],
            'message' => is_array($message) || $message instanceof Collection ? $message[0] : $message,
            'status' => $status,
        ], 200);
    }
    public function returnInvalidData($message, $status = 400)
    {
        return response()->json([
            'data' => (object) [],
            'message' => is_array($message) || $message instanceof Collection ? $message[0] : $message,
            'status' => $status,
        ], 200);
    }
    public function respond($data = '', String $message = 'success', Int $code = 200): JsonResponse
    {
        if (ob_get_length() > 0) ob_end_clean();
        return response()->json(['message' => $message, 'data' => $data], $code);
    }

    public function respondError($failures,string $message = 'error', Int $code = 404): JsonResponse
    {
        // if (ob_get_length() > 0) ob_end_clean();
        return response()->json(['message' => $message, 'failures' => $failures], $code);
    }

    public function respondWithErrorMessage($message, Int $code = 404): JsonResponse
    {
        if (ob_get_length() > 0) ob_end_clean();
        return response()->json(['message' => $message, "code" => $code], $code);
    }

    public function respondCreated(String $message = 'created', Int $code = 201): JsonResponse
    {
        if (ob_get_length() > 0) ob_end_clean();
        
        return response()->json(['message' => $message,], $code);
    }

}
