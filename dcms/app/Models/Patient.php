<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Authenticatable
{
    use HasFactory;

        protected $fillable = [
            'student_number',
            'name',
            'email',
            'phone',
            'birthdate',
            'gender',
            'password',
        ];



    protected $hidden = [
        'password',
    ];
}
