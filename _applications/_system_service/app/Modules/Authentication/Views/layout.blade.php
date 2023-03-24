<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" value="{{ csrf_token() }}"/>
    <title>Tuha V2 Account</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700|Material+Icons" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="{{ mix('css/single-page/auth/base.css') }}" type="text/css" rel="stylesheet"/>
</head>
<body>
    <div class="d-flex flex-column auth-account flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <!--begin::Logo-->
            <div class="logo">
                <a href="{{ route('login') }}" class="mb-5 mr-5">
                    <img src="{{asset('/media/logos/logo-tuha.png')}}" alt="logo" />
                </a>
                <h1>PALEE - single sign on</h1>
            </div>
            <!--end::Logo-->

            <!--begin::Wrapper-->
            <div class="w-lg-500px bg-white rounded shadow-sm p-10 p-lg-15 mx-auto">
                @yield('content')
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->

        <!--begin::Footer-->
        <div class="d-flex flex-center flex-column-auto p-10">
            <!--begin::Links-->
            <div class="d-flex align-items-center fw-bold fs-6">
                <a href="#" class="text-muted text-hover-primary px-2">{{ __('Về chúng tôi') }}</a>
                <a href="#" class="text-muted text-hover-primary px-2">{{ __('Hỗ trợ') }}</a>
            </div>
            <!--end::Links-->
        </div>
        <!--end::Footer-->
    </div>
    <!--end::Authentication-->

</body>
</html>
