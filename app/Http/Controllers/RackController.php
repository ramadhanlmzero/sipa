<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Rack;
use App\Model\Room;
use App\Model\Archive;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Rack::with('cRoom', 'cArchives')->get();
    }

    public function rackWithSlot()
    {
        return Rack::with('cRooms')->where('slot', '>', 0)->orderBy('name', 'ASC')->get();
    }

    public function checkRack()
    {
        $archive = Archive::all('rack_id');
        $relation = Rack::whereIn('id', $archive)->pluck('id');
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
            'slot' => 100,
            'room_id' => $request->room_id
        ];
        $rack = Rack::create($data);
        return $rack;
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
            $rack = Rack::with('cRoom')->find($id);
            $room = Room::all()->whereNotIn('id', $rack->room_id)->sortBy('name');
            $data = [
                'rack' => $rack,
                'room' => $room
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
        $rack = Rack::find($id);
        $data = [
            'name' => $request->name,
            'slot' => 100,
            'room_id' => $request->room_id
        ];
        $rack->update($data);
        return $rack;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rack = Rack::find($id);
        $rack->delete();
        return $rack;
    }
}
