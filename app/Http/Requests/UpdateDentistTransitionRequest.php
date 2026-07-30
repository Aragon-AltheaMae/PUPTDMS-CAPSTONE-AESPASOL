<?php

namespace App\Http\Requests;

use App\Models\DentistTransition;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDentistTransitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
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
            /** @var DentistTransition|null $transition */
            $transition = $this->route('transition');

            if (!$transition) {
                return;
            }

            $successorId = (int) $this->input('default_successor_dentist_id');
            $successor = $successorId ? User::with('role')->find($successorId) : null;

            if ($successorId && $transition->dentist_id === $successorId) {
                $validator->errors()->add('default_successor_dentist_id', 'The departing dentist cannot be their own successor.');
            }

            if ($successor && (optional($successor->role)->slug !== 'dentist' || $successor->status !== 'active')) {
                $validator->errors()->add('default_successor_dentist_id', 'The successor dentist must be an active dentist.');
            }
        });
    }
}
