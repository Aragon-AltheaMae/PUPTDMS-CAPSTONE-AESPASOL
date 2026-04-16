@extends('errors.layout')

@section('title', 'Server Error')
@section('code', '500')

@section('code_styled')
5<span>0</span>0
@endsection

@section('label', 'Internal Error')
@section('message', 'Something went wrong on our end.')
@section('description', 'The page encountered an unexpected server issue while processing your request. Your recent action may not have been completed.')
@section('status', 'System issue detected')

@section('brand_title', 'Clinic service is temporarily unavailable')
@section('brand_text', 'Our system encountered an internal issue while processing your request. Please go back or return to the home page.')
@section('notice_text', 'Try refreshing the page first. If the issue continues, go back and retry the last action after a few moments.')

@section('brand_icon')
<svg fill="none" stroke="white" stroke-width="1.7" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" d="M8.5 3.5c1.2 0 2.2.4 3.5 1.2 1.3-.8 2.3-1.2 3.5-1.2 2.6 0 4.5 2 4.5 5.1 0 2.5-.9 4.8-2.1 7-.8 1.5-1.7 3.3-2.9 3.3-.9 0-1.2-.8-1.5-1.8-.3-1.1-.7-2.2-1.5-2.2s-1.2 1.1-1.5 2.2c-.3 1-.6 1.8-1.5 1.8-1.2 0-2.1-1.8-2.9-3.3-1.2-2.2-2.1-4.5-2.1-7 0-3.1 1.9-5.1 4.5-5.1z"/>
</svg>
@endsection

@section('notice_icon')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86l-7.5 13A2 2 0 0 0 4.5 20h15a2 2 0 0 0 1.71-3.14l-7.5-13a2 2 0 0 0-3.42 0z"/>
</svg>
@endsection