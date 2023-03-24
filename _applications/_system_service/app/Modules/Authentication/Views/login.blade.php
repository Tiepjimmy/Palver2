@extends('Authentication::layout')
@section('content')
    <form id="login-form" method="POST" action="{{ route('login.post') }}" class="form w-100">
        @csrf
        @error('auth_failed')
        <div class="fv-row mb-10">
            <div class="text-danger">{{ $errors->first('auth_failed') }}</div>
        </div>
        @enderror
        <div class="fv-row mb-10">
            <label class="form-label fs-6 fw-bolder text-dark">{{ __('Tên đăng nhập') }}</label>
            <input class="form-control form-control-lg form-control-solid" type="text" name="username" value="{{ old('username') }}" autofocus/>
            @if ($errors->has('username'))
                <div class="text-danger">{{ $errors->first('username') }}</div>
            @endif
        </div>

        <div class="fv-row mb-10">
            <label class="form-label fw-bolder text-dark fs-6 mb-0">{{ __('Mật khẩu') }}</label>
            <input class="form-control form-control-lg form-control-solid" type="password" name="password"/>
            @if ($errors->has('password'))
                <div class="text-danger">{{ $errors->first('password') }}</div>
            @endif
        </div>

        <div class="fv-row mb-10">
            <label class="form-check form-check-custom form-check-solid">
                <input class="form-check-input" type="checkbox" name="remember"/>
                <span class="form-check-label fw-bold text-gray-700 fs-6">{{ __('Ghi nhớ đăng nhập') }}</span>
            </label>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-lg btn-primary w-100 mb-5 g-recaptcha">{{__('Đăng nhập')}}</button>
            {{--            <button type="button" class="btn btn-lg btn-primary w-100 mb-5 g-recaptcha" data-sitekey="{{ config('google.recaptcha_site_key') }}" data-callback='onSubmit'>{{__('Đăng nhập')}}</button>--}}
            <a href="#">{{ __('Đăng ký') }}</a>
        </div>
    </form>
    <script type="text/javascript">
        function onSubmit(){
            document.getElementById("login-form").submit();
        }
    </script>
@endsection
