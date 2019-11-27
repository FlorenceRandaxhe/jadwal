<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modal extends Model
{

    protected $fillable = [
        'session_id', 'teacher_id', 'courses', 'groups', 'exam_type', 'local', 'exam_duration', 'supervisor', 'requests'
    ];


}
