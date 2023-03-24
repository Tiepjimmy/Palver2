<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tuha V2 Account</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700|Material+Icons" rel="stylesheet">

    <!-- Styles -->

    @if (getenv('APP_ENV') === 'local')
        <link rel="stylesheet" href="{{ asset('dev/js/vendor.css?v=' . time()) }}">
    @else
        <link rel="stylesheet" href="{{ mix('js/vendor.css') }}">
    @endif

    <link rel="stylesheet" href="{{ asset('css/style.css?v=' . env('ASSET_VERSION')) }}">

    @if (getenv('APP_ENV') === 'local')
        <link rel="stylesheet" href="{{ asset('dev/css/app.css?v=' . time()) }}">
    @else
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @endif

<!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
</head>
<body>
<noscript>
    <strong>Vui lòng cấu hình bật Javascript trên trình duyệt để sử dụng phần mềm.</strong>
</noscript>

<div id="app">
</div>

<!-- APP SCRIPT -->
@if (getenv('APP_ENV') === 'local')
    <script src="{{ asset('dev/js/app.js?v='.time()) }}"></script>
    <script src="{{ asset('dev/js/vendor.js?v=' . env('ASSET_VERSION')) }}"></script>
    <script src="{{ asset('dev/js/utility.js?v=' . env('ASSET_VERSION')) }}"></script>
@else
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('js/vendor.js?v=' . env('ASSET_VERSION')) }}"></script>
    <script src="{{ asset('js/utility.js?v=' . env('ASSET_VERSION')) }}"></script>
@endif

<script type="text/javascript">
    {{--var _logout = '{{ route('logout') }}';--}}
    {{--var _login = '{{ route('login') }}';--}}
</script>
</body>
</html>
