@extends('errors.layout')

@section('title', 'Session Ended')
@section('code', '419')

@section('tone', 'session')

@section('label', 'Session ended')

@section('message', 'Your session ended for security.')

@section('description', 'The page was open for too long, so the system could not safely complete your last action.')

@section('notice_text', 'Refresh the page or sign in again, then repeat the action.')

@section('primary_label', 'Return Home')
@section('primary_url', url('/'))

@section('brand_icon')
    <svg fill="none" stroke="white" stroke-width="1.7" viewBox="0 0 24 24">
        <circle cx="12" cy="13" r="8"></circle>
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4l2.5 1.5"></path>
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 3h6"></path>
    </svg>
@endsection

@section('notice_icon')
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"></path>
        <circle cx="12" cy="12" r="9"></circle>
    </svg>
@endsection
