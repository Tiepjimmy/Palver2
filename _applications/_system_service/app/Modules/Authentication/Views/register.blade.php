<x-auth-layout>
    <form id="register-form" method="POST" action="{{ route('register.post') }}" class="form w-100" autocomplete="off">
        @csrf
        <div class="fv-row mb-5">
            <label class="form-label fs-6 fw-bolder text-dark">{{ __('Tên shop') }}</label>
            <input class="form-control form-control-lg form-control-solid" type="text" name="ten_to_chuc" value="{{ old('ten_to_chuc') }}" autofocus/>
            @if ($errors->has('ten_to_chuc'))
                <div class="text-danger">{{ $errors->first('ten_to_chuc') }}</div>
            @endif
        </div>

        <div class="fv-row mb-5">
            <label class="form-label fs-6 fw-bolder text-dark">{{ __('Họ tên') }}</label>
            <input class="form-control form-control-lg form-control-solid" type="text" name="ten" value="{{ old('ten') }}" autofocus/>
            @if ($errors->has('ten'))
                <div class="text-danger">{{ $errors->first('ten') }}</div>
            @endif
        </div>

        <div class="fv-row mb-5">
            <label class="form-label fs-6 fw-bolder text-dark">{{ __('Tên đăng nhập') }}</label>
            <input class="form-control form-control-lg form-control-solid" type="text" name="username" value="{{ old('username') }}" autofocus/>
            @if ($errors->has('username'))
                <div class="text-danger">{{ $errors->first('username') }}</div>
            @endif
        </div>

        <div class="fv-row mb-5">
            <label class="form-label fs-6 fw-bolder text-dark">{{ __('Email') }}</label>
            <input class="form-control form-control-lg form-control-solid" type="text" name="email" value="{{ old('email') }}" autofocus/>
            @if ($errors->has('email'))
                <div class="text-danger">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <div class="fv-row mb-5">
            <label class="form-label fw-bolder text-dark fs-6 mb-0">{{ __('Mật khẩu') }}</label>
            <input class="form-control form-control-lg form-control-solid" type="password" name="password"/>
            @if ($errors->has('password'))
                <div class="text-danger">{{ $errors->first('password') }}</div>
            @endif
        </div>


        <div class="fv-row mb-5">
            <label class="form-label fw-bolder text-dark fs-6 mb-0">{{ __('Nhập lại mật khẩu') }}</label>
            <input class="form-control form-control-lg form-control-solid" type="password" name="password_confirmation"/>
            @if ($errors->has('password_confirmation'))
                <div class="text-danger">{{ $errors->first('password_confirmation') }}</div>
            @endif
        </div>

        <div class="row fv-row mb-7 fv-plugins-icon-container">
            <div class="col-xl-6">
                <label class="form-label fs-6 fw-bolder text-dark">{{ __('Số điện thoại') }}</label>
                <input class="form-control form-control-lg form-control-solid" type="text" name="sdt" value="{{ old('sdt') }}"/>
                @if ($errors->has('sdt'))
                    <div class="text-danger">{{ $errors->first('sdt') }}</div>
                @endif
            </div>
            <div class="col-xl-6">
                <label class="form-label fs-6 fw-bolder text-dark">{{ __('Loại hình dịch vụ') }}</label>
               {{--  <select name="id_loai_hinh_kinh_doanh" class="form-control" data-control="select2" >
                    @foreach($dsLoaiHinh as $loaiHinh)
                        <option value="{{$loaiHinh['id']}}">{{$loaiHinh['ten_loai_hinh']}}</option>
                    @endforeach
                </select> --}}
                @if ($errors->has('id_loai_hinh_kinh_doanh'))
                    <div class="text-danger">{{ $errors->first('id_loai_hinh_kinh_doanh') }}</div>
                @endif
            </div>
        </div>

        <div class="text-center">
            <button type="button" class="btn btn-lg btn-primary w-100 mb-5 g-recaptcha" data-sitekey="{{ config('google.recaptcha_site_key') }}" data-callback='onSubmit'>{{__('Đăng ký')}}</button>
            <div class="text-right">
                <a href="{{ route('login') }}">{{ __('Quay lại đăng nhập') }}</a>
            </div>
        </div>
    </form>
    <script type="text/javascript">
        function onSubmit(){
            document.getElementById("register-form").submit();
        }
    </script>
</x-auth-layout>
