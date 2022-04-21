<?php

namespace Modules\User\Http\Controllers\Api\V1\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * @param RegisterRequest $request
     * Register User Methode
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'c_password' => $request->c_password,
            'address' => $request->address,
            'cellphone' => $request->cellphone,
            'postal_code' => $request->postal_code,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('myApp')->plainTextToken;
        return successResponse([
            'user' => $user,
            'token' => $token
        ], 201);
    }

}
