<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'document_type',
        'purpose',
        'request_date',
        'request_time',
        'status',
    ];

    /* =======================
       RELATIONSHIPS
    ======================= */

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
