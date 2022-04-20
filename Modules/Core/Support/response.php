<?php

use \Illuminate\Support\Arr;


if (!function_exists('errorResponse')) {

    /**
     * @param $message
     * @param $status
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    function errorResponse($message, $status, $data = null)
    {
        return response()->json(array_filter(Arr::collapse([
            ['error' => true, 'errors' => $message], $data
        ])), $status);
    }
}


if (!function_exists('successResponse')) {

    /**
     * @param $data
     * @param $code
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    function successResponse($data, $status, $message = null)
    {
        return response()->json(Arr::collapse([
            ['error' => false, 'message' => $message], $data
        ]), $status);
    }
}
