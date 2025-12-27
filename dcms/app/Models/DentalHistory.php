<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DentalHistory extends Model
{
    protected $fillable = ['appointment_id', 'question', 'answer'];
}


