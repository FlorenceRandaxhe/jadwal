<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = ['title', 'mail', 'limit_date'];

    protected $dates = ['created_at', 'updated_at', 'limit_date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'session_teachers', 'session_id', 'teacher_id')->withPivot('complete_modals');
    }

    public function completeModals()
    {
        return $this->hasMany(SessionTeacher::class, 'session_id')->where('complete_modals', true);
    }

    // one session can have many modals
    public function oldmodals()
    {
        return $this->hasMany(Modal::class);
    }

}


