<?php

namespace App\Http\Controllers\Auth;

use App\Http\Api\ApiResponse;
use App\Http\Api\ErrorApiResponse;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    private $ERROR_INVALID_DATA = 100;
    private $ERROR_SAVE_DATA = 101;

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Handle a registration request for the application.
     * @return \Illuminate\Http\Response
     * @internal param \Illuminate\Http\Request $request
     */
    public function register()
    {
        $data = request(['email', 'name', 'password', 'password_confirmation']);

        Log::debug([RegisterController::class, 'register()', '$data', $data]);

        $validator = $this->validator($data);

        $apiResponse = new ApiResponse();

        if ($validator->fails()) {
            $apiResponse->setCode($this->ERROR_INVALID_DATA);
            $apiResponse->setMsg(__('messages.register_invalid_data_error'));
            $apiResponse->setData($validator->errors());

            return respondApiError($apiResponse);
        } else {
            $user = $this->create($data);

            if ($user) {
                $apiResponse->setMsg(__('messages.register_save_data_success'));
                return respondApiSuccess($apiResponse);
            } else {
                $apiResponse->setCode($this->ERROR_SAVE_DATA);
                $apiResponse->setMsg(__('messages.register_save_data_error'));
                return respondApiError($apiResponse);
            }
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
