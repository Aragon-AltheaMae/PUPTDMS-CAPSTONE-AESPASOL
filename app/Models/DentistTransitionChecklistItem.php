<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DentistTransitionChecklistItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'dentist_transition_id',
        'checklist_key',
        'label',
        'is_required',
        'is_completed',
        'remarks',
        'completed_by',
        'completed_at',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function transition()
    {
        return $this->belongsTo(DentistTransition::class, 'dentist_transition_id');
    }

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }
}
