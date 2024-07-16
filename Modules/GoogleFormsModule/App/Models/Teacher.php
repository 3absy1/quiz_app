<?php

namespace Modules\GoogleFormsModule\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Modules\GoogleFormsModule\Database\factories\TeacherFactory;
use Illuminate\Notifications\Notifiable;

class Teacher extends User
{
    use HasFactory ,  Notifiable , HasApiTokens;



    /**
     * The attributes that are mass assignable.
     */
    protected $gaurded = [
    'id',
    ];
    protected $table = 'teachers';

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function newFactory(): TeacherFactory
    {
        //return TeacherFactory::new();
    }

    public function forms(): BelongsToMany
    {
        return $this->belongsToMany(Form::class);
    }
}
