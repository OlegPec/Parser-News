<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Личный кабинет</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">


    {{--------------------------------Новые стили------------------------------------}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- favicons -->
{{--    <link rel="icon" type="image/png" href="{{asset('assets/images/favicon.ico')}}">--}}


    <!-- =========================================================-->
    <!-- All Styles -->
    <!-- ========================================================= -->
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
    <!-- font awesome -->


    <!-- Main Styles -->
{{--    <link rel="stylesheet" href="{{asset('assets/css/main.css?v=1.0')}}">--}}


</head>
<body>

<div class="wrapper">
    {{--<div class="login-close">--}}
        {{--<div class="login-close-container">--}}
            {{--<a href="/" class="evolpay-close">&times;</a>--}}
        {{--</div>--}}
    {{--</div>--}}
    <div class="auth-box">
        <div class="auth-logo">
            <div class="logo">
                <div class="logo-type logo-type-colored">
{{--                    <a href="{{route('mainPage')}}"><img src="{{asset('assets/images/logo-color.png')}}" class=""></a>--}}
                </div>
            </div>
        </div>
        <div class="auth-desc">
            <p class="mb-0">Добро пожаловать</p>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group mb-20">
                <label for="email"><strong>{{ __('E-mail:') }}</strong></label>
                <input type="text" class="form-control" id="email" name="email" required>
                @error('email')
                <div class="alert alert-dismissible alert-danger">{{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                @enderror
            </div>
            <div class="form-group mb-20">
                <label for="password"><strong>{{ __('Пароль:') }}</strong></label>
                <input type="password" class="form-control" id="password" name="password" required>
                @error('password')
                <div class="alert alert-dismissible alert-danger">{{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                @enderror
            </div>
            <div class="form-group mt-20">
                <button type="submit" class="btn btn-primary btn-shadow btn-block auth-btn">Авторизация</button>
            </div>
            <div>
                <hr>

                <hr>
                @if (Route::has('password.request'))
                    <p class="fs-12 text-center text-light">Забыли свой пароль? Воспользуйтесь<a class="text-primary" href="{{ route('password.request') }}">
                            {{ __('формой восстановления пароля') }}.
                        </a></p>
                @endif
                <hr>
                <p class="fs-12 text-center text-light">
                    Нет аккаунта <a href="{{route('register')}}" class="text-primary">Зарегистрируйтесь</a>
                </p>

            </div>



        </form>
    </div>
</div>


<!-- =========================================================-->
<!-- All Scripts -->
<!-- ========================================================= -->
<!-- jquery -->
<script src="{{asset('assets/vendor/jquery/js/jquery-3.2.1.min.js')}}"></script>
<!-- bootstrap -->

<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>

</body>
</html>
