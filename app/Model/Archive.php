<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Model\Category;
use App\Model\Rack;

class Archive extends Model
{
    protected $table = 'archive';
    protected $guarded = [];
    public $incrementing = false;

    public function cUser()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function cRack() {
        return $this->belongsTo(Rack::class, 'rack_id', 'id')->with('cRoom');
    }

    public function cCategory() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
