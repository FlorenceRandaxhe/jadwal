<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session as PHPSession;


class Teacher extends Model
{
    protected $fillable = [
        'name', 'email'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function modals()
    {
        return $this->hasMany(Modal::class)->where('session_id', PHPSession::get('session')->id);
    }

    public function sessions()
    {
        return $this->belongsToMany(Session::class, 'session_teachers');
    }


}
