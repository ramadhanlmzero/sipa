<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Rack;
use App\Model\Archive;
use App\User;

class Room extends Model
{
    protected $table = 'room';
    protected $guarded = [];
    public $timestamps = false;
    public $incrementing = false;

    public function cRacks()
    {
        return $this->hasMany(Rack::class)->with('cArchives');
    }

    public function cUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function cArchives()
    {
        return $this->hasManyThrough(Archive::class, Rack::class);
    }
}
