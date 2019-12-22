<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Model\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $v = Validator::make(
            $request->all(),
            [
                'email' => 'required email unique:users',
                'password'  => 'required min:6 confirmed',
            ]
        );
        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
        $user = new User;
        $user->id = (string) Str::uuid();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt(
            $request->password
        );
        $user->save();
        return response()->json(['status' => 'success'], 200);
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
        }
        return response()->json(['error' => 'login_error'], 401);
    }

    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    public function user(Request $request)
    {
        $user = User::with('cRoles')->find(Auth::user()->id);
        $role = Role::whereHas('cUsers', function ($query) use ($user) {
            $query->where('id', $user->id);
        })->get();
        $privilages = Role::whereHas('cUsers', function ($query) use ($user) {
            $query->where('id', $user->id);
        })->pluck('type')->toArray();
        $privilage = array_values($privilages);
        $data = [
            'user' => $user,
            'role' => $role,
            'privilage' => $privilage
        ];
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    private function guard()
    {
        return Auth::guard();
    }
}
