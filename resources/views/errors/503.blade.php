@extends('errors.layout')

@section('title', 'Temporarily Unavailable')
@section('code', '503')
@section('tone', 'system')

@section('label', 'Temporarily unavailable')

@section(
    'message',
    'The clinic system is temporarily unavailable.'
)

@section(
    'description',
    'We are currently completing maintenance or recovering a system service.'
)

@section(
    'notice_text',
    'Please try again after a few minutes. Your account and saved records are not affected.'
)

@section('primary_label', 'Refresh Page')
@section('primary_url', request()->fullUrl())

@section('notice_icon')
<svg
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="1.8"
    aria-hidden="true">

    <path
        stroke-linecap="round"
        stroke-linejoin="round"
        d="M14.7 6.3a4 4 0 0 0-5.4 5.4L4 17v3h3l5.3-5.3a4 4 0 0 0 5.4-5.4l-2.1 2.1-3.2-3.2 2-1.9Z">
    </path>
</svg>
@endsection