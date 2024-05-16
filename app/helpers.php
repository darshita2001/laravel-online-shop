<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

if (!function_exists('successResponse')) {

    /**
     * Create a JSON response indicating a successful operation.
     *
     * @param string $message
     * @param integer $code
     * @return JsonResponse
     */
    function successResponse(string $message = "Success", int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
        ], $code);
    }
}

if (!function_exists('successResponseWithData')) {

    /**
     *  Create a JSON response with data indicating a successful operation.
     *
     * @param array $data
     * @param string $message
     * @param integer $code
     * @return JsonResponse
     */
    function successResponseWithData(array $data, string $message = "Success", int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}

if (!function_exists('failureResponse')) {

    /**
     * Create a JSON response indicating a failure operation.
     *
     * @param string $message
     * @param integer $code
     * @return JsonResponse
     */
    function failureResponse(string $message = "Internal Server Error", int $code = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $code);
    }
}

if (!function_exists('failureResponseWithErrors')) {

    /**
     *  Create a JSON response with data indicating a failure operation.
     *
     * @param array $data
     * @param string $message
     * @param integer $code
     * @return JsonResponse
     */
    function failureResponseWithErrors(array $errors, string $message = "Internal Server Error", int $code = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}

if (!function_exists('infoLogger')) {

    /**
     * Log an info message along with it's given details.
     *
     * @param string $message
     * @param array|object $data
     * @return void
     */

    function infoLogger(string $message, $data = null)
    {
        Log::info($message, [$data]);
    }
}

if (!function_exists('errorLogger')) {

    /**
     * Log an error message along with throwable details and request information.
     *
     * @param string $message
     * @param Throwable $e
     * @return void
     */

    function errorLogger(string $message, Throwable $e)
    {
        Log::error('' . $message . ' : ' . json_encode($e->getMessage()) . ' | ,
                    Line no. : ' . $e->getLine() . ' | ,
                    File name : ' . $e->getFile() . ' | ,
                    IP address : ' . request()->ip() . ' | ,
                    browser : ' . request()->header('User-Agent'));
    }
}
