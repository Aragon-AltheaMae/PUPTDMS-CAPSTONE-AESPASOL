@extends('errors.layout')

@section('title', 'Forbidden')
@section('code', '403')

@section('code_styled')
4<span>0</span>3
@endsection

@section('label', 'Access Denied')
@section('message', 'You do not have permission to access this page.')
@section('description', 'Your account does not have the required permissions for this resource or action.')
@section('status', 'Restricted access')

@section('brand_title', 'This area is restricted')
@section('brand_text', 'The system blocked your request because your current role does not have access to this page.')
@section('notice_text', 'Return to the previous page or go back home. Contact an administrator if you believe this is incorrect.')

@section('brand_icon')
<svg fill="none" stroke="white" stroke-width="1.7" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 4v5c0 5-3.5 7.5-7 9-3.5-1.5-7-4-7-9V7l7-4Z"/>
    <path stroke-linecap="round" stroke-linejoin="round" d="M9.5 12.5l1.7 1.7 3.3-3.7"/>
</svg>
@endsection

@section('notice_icon')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path stroke-linecap="round" stroke-linejoin="round" d="M18 6 6 18M6 6l12 12"/>
</svg>
@endsection