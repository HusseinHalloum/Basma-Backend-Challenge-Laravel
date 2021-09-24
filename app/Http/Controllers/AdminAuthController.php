<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function register(RegisterAdminRequest $request)
    {
        // dd($request->all());
        $admin = Admin::create([
             'firstname' => $request->firstname,
             'lastname' => $request->lastname,
             'email'    => $request->email,
             'phone'    => $request->phone,
             'password' => $request->password,
         ]);

        $token = auth('admins')->login($admin);

        return $this->respondWithToken($token);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('admins')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        return $this->respondWithToken($token);
    }

    public function logout()
    {
        
        auth('admins')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('admins')->factory()->getTTL() * 60,
            'admin' => auth('admins')->user(),
        ]);
    }
}
