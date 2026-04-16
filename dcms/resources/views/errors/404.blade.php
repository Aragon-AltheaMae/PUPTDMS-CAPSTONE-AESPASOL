@extends('errors.layout')

@section('title', 'Page Not Found')
@section('code', '404')

@section('code_styled')
4<span>0</span>4
@endsection

@section('label', 'Page Not Found')
@section('message', 'We could not find the page you requested.')
@section('description', 'The page may have been moved, renamed, deleted, or the link you opened may be invalid.')
@section('status', 'Missing page')

@section('brand_title', 'The requested page is unavailable')
@section('brand_text', 'The resource you are trying to access could not be located in the clinic management system.')
@section('notice_text', 'Check the link, go back to the previous page, or return home to continue browsing the system.')

@section('brand_icon')
<svg fill="none" stroke="white" stroke-width="1.7" viewBox="0 0 24 24">
    <circle cx="11" cy="11" r="6"></circle>
    <path stroke-linecap="round" stroke-linejoin="round" d="M20 20l-3.5-3.5"></path>
</svg>
@endsection

@section('notice_icon')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <circle cx="12" cy="12" r="9"></circle>
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v5"></path>
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16h.01"></path>
</svg>
@endsection