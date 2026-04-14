<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacultyProfile extends Model
{
    protected $table = 'faculty_profiles';

    protected $fillable = [
        'faculty_id',
        'birthday',
        'gender',
        'department',
        'house_num',
        'street',
        'barangay',
        'city',
        'province',
        'country',
        'zipcode',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}