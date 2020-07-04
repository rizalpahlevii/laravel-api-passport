<?php

namespace App\Traits;

trait ResponseAPI
{
    /**
     * Core Response function
     *
     * @param [type] $message
     * @param [type] $data
     * @param [type] $statusCode
     * @param boolean $isSuccess
     * @return void
     */
    public function coreResponse($message, $data = null, $statusCode, $isSuccess = true)
    {
        if (!$message) return response()->json(['message' => 'Message is required'], 500);

        if (!$isSuccess) {
            return response()->json([
                'message' => $message,
                'error' => false,
                'code' => $statusCode,
                'results' => $data
            ], $statusCode);
        } else {
            return response()->json([
                'message' => $message,
                'error' => true,
                'code' => $statusCode,
            ], $statusCode);
        }
    }

    /**
     * Success Response
     *
     * @param [type] $message
     * @param [type] $data
     * @param integer $statusCode
     * @return void
     */
    public function success($message, $data, $statusCode = 200)
    {
        return $this->coreResponse($message, $data, $statusCode, false);
    }

    /**
     * Error Response
     *
     * @param [type] $message
     * @param integer $statusCode
     * @return void
     */
    public function error($message, $statusCode = 500)
    {
        return $this->coreResponse($message, null, $statusCode, false);
    }
}
