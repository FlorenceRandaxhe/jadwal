<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public function sessions()
    {
        return $this->belongsToMany(Session::class, 'session_teachers');
    }

}
