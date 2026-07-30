@extends('errors.layout')

@section('title', 'Page Expired')
@section('code', '419')

@section('code_styled')
4<span>1</span>9
@endsection

@section('label', 'Session Expired')
@section('message', 'Your session has expired.')
@section('description', 'This usually happens when the page has been idle for too long or the form token is no longer valid.')
@section('status', 'Session timeout')

@section('brand_title', 'Your session is no longer active')
@section('brand_text', 'The system could not continue the request because your secure session expired before submission.')
@section('notice_text', 'Refresh the page and try the action again. If needed, log in again before resubmitting the form.')

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