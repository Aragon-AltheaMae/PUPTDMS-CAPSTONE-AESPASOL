<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['patient', 'datetime', 'service'];

    // One appointment has many dental history records
    public function dentalHistories()
    {
        return $this->hasMany(DentalHistory::class);
    }

    // One appointment has many medical history records
    public function medicalHistories()
    {
        return $this->hasMany(MedicalHistory::class);
    }
}
