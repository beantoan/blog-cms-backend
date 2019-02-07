<?php

namespace App\Http\Controllers\Auth;

use App\Http\Api\ApiResponse;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            $apiResponse = new ApiResponse();

            $apiResponse->setMsg(__('messages.login_error'));

            return respondUnauthorized($apiResponse);
        }

        return respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        $apiResponse = new ApiResponse();

        $apiResponse->setMsg(__('messages.logout_success'));

        return respondApiSuccess($apiResponse);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return respondWithToken(auth()->refresh());
    }
}
