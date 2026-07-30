<?php

namespace App\Http\Requests;

use App\Models\DentistTransition;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDentistTransitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'dentist_id' => ['required', 'integer', 'exists:users,id'],
            'transition_type' => ['required', Rule::in(DentistTransition::TYPES)],
            'default_successor_dentist_id' => ['nullable', 'integer', 'exists:users,id'],
            'last_working_date' => ['required', 'date'],
            'access_ends_at' => ['required', 'date', 'after_or_equal:last_working_date'],
            'handover_notes' => ['nullable', 'string'],
            'remarks' => ['nullable', 'string'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $dentistId = (int) $this->input('dentist_id');
            $successorId = (int) $this->input('default_successor_dentist_id');

            $dentist = User::with('role')->find($dentistId);
            $successor = $successorId ? User::with('role')->find($successorId) : null;

            if (!$dentist || optional($dentist->role)->slug !== 'dentist') {
                $validator->errors()->add('dentist_id', 'The selected departing user must be a dentist.');
            }

            if ($successorId && $dentistId === $successorId) {
                $validator->errors()->add('default_successor_dentist_id', 'The departing dentist cannot be their own successor.');
            }

            if ($successor && (optional($successor->role)->slug !== 'dentist' || $successor->status !== 'active')) {
                $validator->errors()->add('default_successor_dentist_id', 'The successor dentist must be an active dentist.');
            }

            $duplicateExists = DentistTransition::query()
                ->where('dentist_id', $dentistId)
                ->whereIn('status', ['draft', 'pending_review', 'handover_in_progress', 'scheduled'])
                ->exists();

            if ($duplicateExists) {
                $validator->errors()->add('dentist_id', 'This dentist already has an active transition.');
            }
        });
    }
}
