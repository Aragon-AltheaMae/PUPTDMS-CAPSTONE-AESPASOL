<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculties';

    protected $fillable = [
        'user_id',
        'faculty_type_id',
        'fesr_user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}