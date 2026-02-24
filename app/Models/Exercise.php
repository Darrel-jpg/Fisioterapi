<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $guarded = [];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}