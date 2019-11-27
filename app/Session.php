<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'title', 'mail', 'user_id', 'limit_date'
    ];

    protected $dates = ['created_at', 'updated_at', 'limit_date'];


    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'session_teachers', 'session_id', 'teacher_id');
    }


}


