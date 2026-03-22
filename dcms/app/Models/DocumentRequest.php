<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'reference_number',
        'document_type',
        'purpose',
        'priority',
        'request_date',
        'request_time',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}