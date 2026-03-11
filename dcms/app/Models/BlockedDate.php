<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlockedDate extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'reason', 'note', 'created_by'];

    protected $casts = ['date' => 'date'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}