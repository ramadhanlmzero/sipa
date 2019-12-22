<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('cArchives')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'id' => (string) Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];
        $user = User::create($data);
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            return User::find($id);
        } 
        catch (ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Error',
                'errors' => $exception->errors(),
            ], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->password = bcrypt($request->password);
        $user->update();
        return $user;
    }

    public function renew(Request $request, $id)
    {
        try {
            $user = User::find($id);
            $data = [
                'name' => $request->name,
                'email' => $request->email
            ];
            if (Hash::check($request->password, $user->password)) {
                $user->update($data);
                return $user;
            } else {
                return response()->json(['status' => 'error']);
            }
        } 
        catch (ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Error',
                'errors' => $exception->errors(),
            ], 422);
        }
    }

    public function renewpassword(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (Hash::check($request->oldpassword, $user->password)) {
                $user->password = bcrypt($request->newpassword);
                $user->update();
                return $user;
            } else {
                return response()->json(['status' => 'error']);
            }
            return $user;
        }
        catch (ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Error',
                'errors' => $exception->errors(),
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return $user;
    }
}
