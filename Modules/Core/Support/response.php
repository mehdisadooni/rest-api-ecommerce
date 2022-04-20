<?php
use \Illuminate\Support\Arr;


if (!function_exists('errorResponse')) {

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    function errorResponse($data = null)
    {
        return response()->json(Arr::collapse([
            ['error' => true], $data
        ]));
    }
}


if (!function_exists('successResponse')) {

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    function successResponse($data = null)
    {
        return response()->json(Arr::collapse([
            ['error' => false], $data
        ]));
    }
}
