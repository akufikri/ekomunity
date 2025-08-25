<?php

namespace App\Traits;

trait ApiResponder
{
    public function success($data, $message, $code = null)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function error($message = null, $code = null, $data = null)
    {
       return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
