<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Point;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    // register user
    public function register(Request $request)
    {

        $request->validate([
            'username' => 'required | string | between:2,40 | unique:users',
            'password' => 'required | string | between:6,10',
            'role' => 'required | string',
        ]);

        $data = [
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ];
        $user = User::create($data);

        if ($data['role'] == 'user') {

            // check request have point or not
            $point = $request->has('point') ? $request->point : 0;

            $pointData = [
                'point' => $point,
                'user_id' => $user->id,
            ];

            Point::create($pointData);
        }


        return response()->json([
            'status' => 'OK',
            'message' => "successfully created"
        ], 200);
    }

    // login user
    public function login(Request $request)
    {

        $request->validate([
            'username' => 'required | string',
            'password' => 'required | string',
            'role' => 'required | string',
        ]);

        $credentials = $request->only(['username', 'password', 'role']);


        $user = User::where('username','=', $credentials['username'])
            ->where('role','=', $credentials['role'])->first();

        if (empty($user) || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid User',
            ], 401);
        }

        $token = $user->createToken('access Token')->accessToken;

        return response()->json([
            'status' => 'OK',
            'message' => "successfully login",
            'token' => $token,
            'type' => 'bearer',

        ], 200);
    }

    // logot user
    public function logout()
    {

        Auth::user()->tokens()->delete();

        return response()->json([
            'status' => 'OK',
            'message' => 'logout successfully',
        ], 200);
    }
}
