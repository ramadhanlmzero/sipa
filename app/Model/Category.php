<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Archive;

class Category extends Model
{
    protected $table = 'category';
    protected $guarded = [];
    public $timestamps = false;
    public $incrementing = false;

    public function cArchives() {
        return $this->hasMany(Archive::class, 'category_id', 'id');
    }
}
