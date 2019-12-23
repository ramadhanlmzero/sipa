<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Model\Archive;
use App\Model\Category;
use App\Model\Rack;
use App\Model\Room;
use Illuminate\Validation\ValidationException;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Archive::with('cRack', 'cCategory', 'cUser')->get();
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
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:doc,docx,ppt,pptx,xlsx,xls,csv,pdf,jpeg,jpg,png|max:3000',
            'category_id' => 'required',
            'rack_id' => 'required'
        ], [
            'file.required' => 'Pilih file terlebih dahulu',
            'file.mimes' => 'Hanya menerima format file microsoft office, pdf, dan gambar',
            'file.max' => 'File terlalu besar',
            'category_id.required' => 'Pilih kategori terlebih dahulu',
            'rack_id.required' => 'Pilih rak terlebih dahulu'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }
        else {
            if ($request->hasFile("file")) {
                $file = $request->file;
                $name = str_replace('/', '_', $request->number);
                $filename = $name . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/archive/', $filename);
            }
            $data = [
                'id' => (string) Str::uuid(),
                'category_id' => $request->category_id,
                'rack_id' => $request->rack_id,
                'number' => $request->number,
                'title' => $request->title,
                'file' => (string) $filename,
                'note' => $request->note,
                'created_by' => auth()->user()->id
            ];

            $rack = Rack::find($data['rack_id']);
            $room = Room::find($rack->room_id);
            if($room->user_id == auth()->user()->id) {
                $data['status'] = "Sudah Dikonfirmasi";
            }
            else {
                $data['status'] = "Belum Dikonfirmasi";
            }

            $archive = Archive::create($data);
            $category = Category::find($data['category_id']);
            $category->number += 1;
            $category->update();
            // $rack->slot -= 1;
            // $rack->update();
            return $archive;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Archive::with('cUser', 'cRack', 'cCategory')->find($id);
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
            $archive = Archive::with('cRack', 'cCategory', 'cUser')->find($id);
            $rack = Rack::with('cRoom')->where('id', '!=' , $archive->rack_id)->get();
            $data = [
                'archive' => $archive,
                'rack' => $rack
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
        $archive = Archive::find($id);
        $data = [
            'rack_id' => $request->rack_id,
            'title' => $request->title,
            'note' => $request->note,
        ];
        $rack = Rack::find($data['rack_id']);
        $room = Room::find($rack->room_id);
        if ($room->user_id == auth()->user()->id) {
            $data['status'] = "Sudah Dikonfirmasi";
        }

        if ($request->hasFile("file")) {
            $validator = Validator::make($request->all(), [
                'file' => 'mimes:doc,docx,ppt,pptx,xlsx,xls,csv,pdf,jpeg,jpg,png|max:3000'
            ], [
                'file.mimes' => 'Hanya menerima format file microsoft office, pdf, dan gambar',
                'file.max' => 'File terlalu besar'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
            }
            else {
                $image_path = public_path("storage/archive/" . $archive->file);
                if (is_file($image_path)) {
                    unlink($image_path);
                }
                $file = $request->file;
                $name = str_replace('/', '_', $request->number);
                $filename = $name . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/archive/', $filename);
                $data['file'] = (string) $filename;
            }
        }
        // $rack = Rack::find($archive->rack_id);
        // $rack->slot += 1;
        // $rack->update();
        // $rack2 = Rack::find($data['rack_id']);
        // $rack2->slot -= 1;
        // $rack2->update();
        $archive->update($data);
        return $archive;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $archive = Archive::find($id);
        $image_path = public_path("storage/archive/".$archive->file);
        if (is_file($image_path)) {
            unlink($image_path);
        }
        // $rack = Rack::find($archive->rack_id);
        // $rack->slot += 1;
        // $rack->update();
        $archive->delete();
        return $archive;
    }

    public function confirm($id)
    {
        $archive = Archive::find($id);
        $archive->status = 'Sudah Dikonfirmasi';
        $archive->update();
        return $archive;
    }

    public function undoconfirm($id)
    {
        $archive = Archive::find($id);
        $archive->status = 'Belum Dikonfirmasi';
        $archive->update();
        return $archive;
    }

    public function rackinroom($id)
    {
        return Room::with('cRacks')->find($id);
    }
}
