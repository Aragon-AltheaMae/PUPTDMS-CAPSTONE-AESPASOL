@extends('errors.layout')

@section('title', 'Too Many Requests')
@section('code', '429')

@section('code_styled')
4<span>2</span>9
@endsection

@section('label', 'Too Many Requests')
@section('message', 'You are sending requests too quickly.')
@section('description', 'The system has temporarily limited repeated actions to protect the service and keep requests stable.')
@section('status', 'Rate limit active')

@section('brand_title', 'Request limit reached')
@section('brand_text', 'Too many repeated requests were detected in a short period, so the system paused this action temporarily.')
@section('notice_text', 'Wait a few moments before trying again. Avoid repeatedly refreshing or resubmitting the same action.')

@section('brand_icon')
<svg fill="none" stroke="white" stroke-width="1.7" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 2"></path>
    <circle cx="12" cy="12" r="9"></circle>
</svg>
@endsection

@section('notice_icon')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01"></path>
    <path stroke-linecap="round" stroke-linejoin="round" d="M10.29 3.86l-7.5 13A2 2 0 0 0 4.5 20h15a2 2 0 0 0 1.71-3.14l-7.5-13a2 2 0 0 0-3.42 0z"/>
</svg>
@endsection