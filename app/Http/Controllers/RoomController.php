<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Room;
use App\Model\Rack;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Room::with('cUser', 'cRacks.cArchives')->get();
    }

    public function checkRoom()
    {
        $rack = Rack::all('room_id');
        $relation = Room::whereIn('id', $rack)->pluck('id');
        return $relation;
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
            'code' => $request->code,
            'user_id' => $request->user_id
        ];
        $room = Room::create($data);
        return $room;
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
            $room = Room::with('cUser')->find($id);
            $user = User::all()->whereNotIn('id', $room->user_id)->sortBy('name');
            $data = [
                'room' => $room,
                'user' => $user
            ];
            return $data;
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
        $room = Room::find($id);
        $data = [
            'name' => $request->name,
            'code' => $request->code,
            'user_id' => $request->user_id
        ];
        $room->update($data);
        return $room;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = Room::find($id);
        $room->delete();
        return $room;
    }
}
