<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}"/>
    <title>Tuha V2 Account</title>
    <base href="{{URL::to('/')}}"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700|Material+Icons" rel="stylesheet">
    <link href="{{ mix('css/style.vue.css') }}" type="text/css" rel="stylesheet"/>
</head>
<body>
<div id="app">
</div>
<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    var _logout = '{{ route('logout') }}';
    var _login = '{{ route('login') }}';
</script>
</body>
</html>
