<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Point;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    //
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index(Request $request)
    {

        $request->validate([
            'role' => 'required | string',
        ]);

        $role = $request->role;

        $users = User::where('role', '=', $role)->get();

        if (count($users) > 0) {
            return response()->json([
                'success' => 'OK',
                'users' => $users,
            ], 200);
        }

        return response()->json([
            'success' => 'Not Found',
            'message' => 'users with ' . $request->role . ' not found',
        ], 404);
    }

    // Add point
    public function addPoint(Request $request, $id)
    {
        $request->validate([
            'point' => 'required | string',
        ]);

        // user id
        $user_id  = $id;

        //get point
        $getPoints = Point::where('user_id', $user_id)->first();

        $request['point'] = $request->point + $getPoints['point'];
        // add point
        $addPoints = Point::where('user_id', $user_id)->update($request->all());

        if (!$addPoints) {
            return response()->json([
                'status' => 'Not Found',
                'message' => 'User with id ' . $user_id . ' is not founded',
            ], 404);
        }
        return response()->json([
            'status' => 'OK',
            'message' => 'successfully added',
        ], 200);
    }
}
