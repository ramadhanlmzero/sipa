<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Room;
use App\Model\Archive;

class Rack extends Model
{
    protected $table = 'rack';
    protected $guarded = [];
    public $timestamps = false;
    public $incrementing = false;

    public function cArchives() {
        return $this->hasMany(Archive::class)->with('cUser');
    }

    public function cRoom() {
        return $this->belongsTo(Room::class, 'room_id', 'id')->with('cUser');
    }
}
