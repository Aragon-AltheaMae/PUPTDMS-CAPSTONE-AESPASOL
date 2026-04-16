@extends('errors.layout')

@section('title', 'Unauthorized')
@section('code', '401')

@section('code_styled')
4<span>0</span>1
@endsection

@section('label', 'Authentication Required')
@section('message', 'You need to sign in first.')
@section('description', 'This page is only available to authenticated users. Please log in and try again.')
@section('status', 'Login required')

@section('brand_title', 'Authentication is required')
@section('brand_text', 'Your request cannot be completed because your account session is missing or not authorized.')
@section('notice_text', 'Go back to the previous page or return home, then sign in before trying again.')

@section('brand_icon')
<svg fill="none" stroke="white" stroke-width="1.7" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.75a4.25 4.25 0 1 0-8.5 0v2.75m-1.25 0h10.5A1.75 1.75 0 0 1 19 12.25v6A1.75 1.75 0 0 1 17.25 20h-10.5A1.75 1.75 0 0 1 5 18.25v-6A1.75 1.75 0 0 1 6.75 10.5Z"/>
</svg>
@endsection

@section('notice_icon')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86l-7.5 13A2 2 0 0 0 4.5 20h15a2 2 0 0 0 1.71-3.14l-7.5-13a2 2 0 0 0-3.42 0z"/>
</svg>
@endsection