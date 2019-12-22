<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Role extends Model
{
    protected $table = 'role';
    protected $guarded = [];
    public $timestamps = false;
    public $incrementing = false;

    public function cUsers() {
        return $this->belongsToMany(User::class);
    }
}
