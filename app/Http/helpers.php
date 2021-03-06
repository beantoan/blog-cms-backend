<?php
/**
 * Created by PhpStorm.
 * User: beantoan
 * Date: 2/6/19
 * Time: 14:06
 */

use App\Http\Api\ApiResponse;
use Illuminate\Http\Response;

if (!function_exists('createJwtResponse')) {
    function createJwtResponse($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}

if (!function_exists('respondWithToken')) {
    function respondWithToken($token)
    {
        return response()->json(createJwtResponse($token));
    }
}

if (!function_exists('respondApiSuccess')) {
    function respondApiSuccess(ApiResponse $apiResponse)
    {
        return response()->json($apiResponse->toArray(), Response::HTTP_OK);
    }
}

if (!function_exists('respondApiError')) {
    function respondApiError(ApiResponse $apiResponse)
    {
        return response()->json($apiResponse->toArray(), Response::HTTP_BAD_REQUEST);
    }
}

if (!function_exists('respondUnauthorized')) {
    function respondUnauthorized(ApiResponse $apiResponse)
    {
        return response()->json($apiResponse->toArray(), Response::HTTP_UNAUTHORIZED);
    }
}