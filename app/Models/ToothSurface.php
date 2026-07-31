<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Tooth;
use App\Models\ToothLegend;

class ToothSurface extends Model
{
    use HasFactory;

    protected $fillable = [
        'tooth_id',
        'surface_number',
    ];

    public function tooth()
    {
        return $this->belongsTo(Tooth::class);
    }

    public function legends()
    {
        return $this->belongsToMany(ToothLegend::class, 'tooth_surface_legends', 'tooth_surface_id', 'legend_id')
            ->withTimestamps();
    }
}