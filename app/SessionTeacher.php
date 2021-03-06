<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SessionTeacher extends Model
{
    protected $fillable = [
        'session_id', 'teacher_id', 'complete_modals'
    ];

    protected $dates = ['created_at', 'updated_at'];

}
