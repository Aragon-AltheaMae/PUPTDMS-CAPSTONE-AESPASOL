@csrf
@if (($formMethod ?? 'POST') !== 'POST')
@method($formMethod)
@endif

<div class="dt-form-grid">
    <div>
        <label class="dt-label" for="dentist_id">Departing Dentist</label>
        <select id="dentist_id" name="dentist_id" class="dt-input" @if($transition->exists) disabled @endif required>
            <option value="">Select dentist</option>
            @foreach ($dentists as $dentist)
            <option value="{{ $dentist->id }}" @selected(old('dentist_id', $transition->dentist_id) == $dentist->id)>
                {{ $dentist->name }}
            </option>
            @endforeach
        </select>
        @if($transition->exists)
        <input type="hidden" name="dentist_id" value="{{ $transition->dentist_id }}">
        @endif
        @error('dentist_id')
        <p class="dt-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="dt-label" for="transition_type">Transition Reason</label>
        <select id="transition_type" name="transition_type" class="dt-input" required>
            <option value="">Select reason</option>
            @foreach ($types as $type)
            <option value="{{ $type }}" @selected(old('transition_type', $transition->transition_type) === $type)>
                {{ str_replace('_', ' ', ucfirst($type)) }}
            </option>
            @endforeach
        </select>
        @error('transition_type')
        <p class="dt-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="dt-label" for="last_working_date">Last Working Date</label>
        <input id="last_working_date" type="date" name="last_working_date" class="dt-input"
            value="{{ old('last_working_date', optional($transition->last_working_date)->format('Y-m-d')) }}" required>
        @error('last_working_date')
        <p class="dt-error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="dt-label" for="access_ends_at">Access Expiration</label>
        <input id="access_ends_at" type="datetime-local" name="access_ends_at" class="dt-input"
            value="{{ old('access_ends_at', optional($transition->access_ends_at)->format('Y-m-d\TH:i')) }}" required>
        @error('access_ends_at')
        <p class="dt-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="dt-span-2">
        <label class="dt-label" for="default_successor_dentist_id">Default Successor Dentist</label>
        <select id="default_successor_dentist_id" name="default_successor_dentist_id" class="dt-input">
            <option value="">No default successor yet</option>
            @foreach ($dentists as $dentist)
            @continue($dentist->id === $transition->dentist_id)
            <option value="{{ $dentist->id }}" @selected(old('default_successor_dentist_id', $transition->default_successor_dentist_id) == $dentist->id)>
                {{ $dentist->name }}
            </option>
            @endforeach
        </select>
        @error('default_successor_dentist_id')
        <p class="dt-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="dt-span-2">
        <label class="dt-label" for="handover_notes">Handover Notes</label>
        <textarea id="handover_notes" name="handover_notes" class="dt-input dt-textarea" rows="5"
            placeholder="Add transition notes, endorsements, or continuity instructions...">{{ old('handover_notes', $transition->handover_notes) }}</textarea>
        @error('handover_notes')
        <p class="dt-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="dt-span-2">
        <label class="dt-label" for="remarks">Supporting Remarks</label>
        <textarea id="remarks" name="remarks" class="dt-input dt-textarea" rows="3"
            placeholder="Optional remarks for admin review...">{{ old('remarks', $transition->remarks) }}</textarea>
        @error('remarks')
        <p class="dt-error">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="dt-form-actions">
    <a href="{{ route('admin.dentist-transitions.index') }}" class="dt-btn dt-btn-secondary">Back</a>
    <button type="submit" class="dt-btn dt-btn-primary">{{ $transition->exists ? 'Save Changes' : 'Create Transition' }}</button>
</div>
