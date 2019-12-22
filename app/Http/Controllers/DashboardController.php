<?php

namespace App\Http\Controllers;

use App\User;
use App\Model\Archive;
use App\Model\Rack;
use App\Model\Room;
use App\Model\Category;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $count = [
            'user' => User::count(),
            'archive' => Archive::count(),
            'category' => Category::count(),
            'rack' => Rack::count(),
            'yourarchive' => Archive::where("created_by", Auth::user()->id)->count(),
            'log' => Archive::with('cUser')->orderBy('created_at', 'DESC')->take(5)->get(),
            'activity_create' => Archive::whereColumn('created_at', 'updated_at')->take(5)->count(),
            'notification' => Room::with('cRacks')->where('user_id', auth()->user()->id)->whereHas('cRacks', function ($query) {
                $query->whereHas('cArchives', function ($query2) {
                    $query2->where('status', 'Belum Dikonfirmasi')->take(5);
                });
            })->get(),
            'active' => User::whereHas('cRoles', function ($q) {
                $q->where('type', 'Petugas');
            })->withCount('cArchives')->orderBy('c_archives_count', 'DESC')->orderBy('name', 'ASC')->take(5)->get(),
            'status_false' => Archive::where('status', 'false')->count(),
            'status_true' => Archive::where('status', 'true')->count(),
            'timestamp_false' => Archive::where('status', 'false')->orderBy('updated_at', 'DESC')->first('updated_at'),
            'timestamp_true' => Archive::where('status', 'true')->orderBy('updated_at', 'DESC')->first('updated_at'),
            'year' => Archive::selectRaw('extract(year from created_at) as year')->distinct()->orderBy('year', 'DESC')->get()
        ];
        return $count;
    }

    public function chart() {
        $category = [
            'name' => Category::pluck('name'),
            'total' => Category::withCount('cArchives')->pluck('c_archives_count')
        ];
        $rack = [
            'name' => Rack::pluck('name'),
            'total' => Rack::withCount('cArchives')->pluck('c_archives_count')
        ];
        $data = [
            'category' => $category,
            'rack' => $rack
        ];
        return $data;
    }

    public function chart2($year) {
        $data = [
            Archive::whereYear('created_at', $year)->whereMonth('created_at', 1)->count(),
            Archive::whereYear('created_at', $year)->whereMonth('created_at', 2)->count(),
            Archive::whereYear('created_at', $year)->whereMonth('created_at', 3)->count(),
            Archive::whereYear('created_at', $year)->whereMonth('created_at', 4)->count(),
            Archive::whereYear('created_at', $year)->whereMonth('created_at', 5)->count(),
            Archive::whereYear('created_at', $year)->whereMonth('created_at', 6)->count(),
            Archive::whereYear('created_at', $year)->whereMonth('created_at', 7)->count(),
            Archive::whereYear('created_at', $year)->whereMonth('created_at', 8)->count(),
            Archive::whereYear('created_at', $year)->whereMonth('created_at', 9)->count(),
            Archive::whereYear('created_at', $year)->whereMonth('created_at', 10)->count(),
            Archive::whereYear('created_at', $year)->whereMonth('created_at', 11)->count(),
            Archive::whereYear('created_at', $year)->whereMonth('created_at', 12)->count()
        ];
        return $data;
    }
}
