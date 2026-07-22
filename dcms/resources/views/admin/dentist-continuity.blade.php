@extends('layouts.app')

@section('layout-role', 'admin')
@section('title', $transition->exists ? 'Edit Dentist Transition' : 'Create Dentist Transition')
@section('styles')
@vite('resources/css/pages/admin/dentist-continuity.css')
@endsection

@section('content')
<main id="mainContent" class="admin-page-shell page-enter mode-list continuity-page">
    <div class="w-full dt-wrap">
        @include('admin.dentist-transitions._hero', [
            'kicker' => 'Dentist Continuity Management',
            'title' => $transition->exists ? 'Update Transition Plan' : 'Create Transition Plan',
        ])

        @if (session('success'))
        <div class="dt-alert dt-alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
        <div class="dt-alert dt-alert-error">{{ session('error') }}</div>
        @endif

        <div class="dt-panel">
            <div class="dt-section-head">
                <div>
                    <h2>{{ $transition->exists ? 'Transition Details' : 'New Transition Details' }}</h2>
                    <p>Match the handover form with your admin workflow by keeping the departure, successor, and timing details in one structured card.</p>
                </div>
            </div>

            <form action="{{ $formAction }}" method="POST">
                @include('admin.dentist-transitions._form')
            </form>
        </div>
    </div>
</main>
@endsection
