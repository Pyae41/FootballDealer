<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // get all user data
    public function getUserData()
    {
        $name = auth()->user()->username;
        $role = auth()->user()->role;

        $user = User::select('users.*', 'points.point', 'points.updated_at')
            ->leftJoin('points', 'users.id', '=', 'points.user_id')
            ->where('username','=',$name)
            ->where('role','=',$role)
            ->first();


        return response()->json([
            'status' => 'OK',
            'user' => $user,
        ], 200);
    }
}
