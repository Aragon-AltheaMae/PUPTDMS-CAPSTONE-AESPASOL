@extends('errors.layout')

@section('title', 'Service Unavailable')
@section('code', '503')

@section('code_styled')
5<span>0</span>3
@endsection

@section('label', 'Service Unavailable')
@section('message', 'The service is temporarily unavailable.')
@section('description', 'The clinic system is currently under maintenance or temporarily unable to handle your request.')
@section('status', 'Maintenance active')

@section('brand_title', 'System maintenance is in progress')
@section('brand_text', 'Some clinic services are temporarily unavailable while system maintenance or recovery is being completed.')
@section('notice_text', 'Please try again after a short while. Return home if you want to continue using the available parts of the system.')

@section('brand_icon')
<svg fill="none" stroke="white" stroke-width="1.7" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" d="M14.7 6.3a4 4 0 0 0-5.4 5.4L4 17v3h3l5.3-5.3a4 4 0 0 0 5.4-5.4l-2.1 2.1-3.2-3.2 2-1.9Z"/>
</svg>
@endsection

@section('notice_icon')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"></path>
    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-3.2-6.9"></path>
</svg>
@endsection