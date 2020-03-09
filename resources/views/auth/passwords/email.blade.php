<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Личный кабинет</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,500,200,100&subset=latin,cyrillic" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">

    {{--------------------------------Новые стили------------------------------------}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- favicons -->
    <link rel="icon" type="image/png" href="{{asset('assets/images/favicon.png')}}">
    <link rel="apple-touch-icon" href="{{asset('assets/images/apple-touch-icon.png')}}">

    <!-- =========================================================-->
    <!-- All Styles -->
    <!-- ========================================================= -->
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <!-- font awesome -->
    <link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
    <!-- simplebar scroll -->
    <link rel="stylesheet" href="{{asset('assets/vendor/simplebar/css/simplebar.min.css')}}">

    <!-- Main Styles -->
    <link rel="stylesheet" href="{{asset('assets/css/main.css?v=1.0')}}">

    <script src="{{asset('assets/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/vendor/datatables/js/dataTables.responsive.min.js')}}"></script>

</head>
<body>

<div class="wrapper">
    <div class="auth-box">
        <div class="auth-logo">
            <div class="logo">
                <div class="logo-type logo-type-colored">
                    <a href="{{route('mainPage')}}"><img src="{{asset('assets/images/logo-color.png')}}" class=""></a>
                </div>
            </div>
        </div>
        <div class="auth-desc">
            <p class="mb-0">Добро пожаловать</p>
        </div>
        <form method="POST" action="{{ route('password.update') }}">
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

            <div class="form-group mt-20">
                <button type="submit" class="btn btn-primary btn-shadow btn-block auth-btn">Отправить пароль на E-mail</button>
            </div>
            <div>

                <hr>
                <p class="fs-12 text-center text-light">
                    Нет аккаунта <a href="{{route('registration')}}" class="text-primary">Зарегистрируйтесь</a>
                </p>

            </div>
            <div class="text-center pt-3 login-footer_brand">EvolGroup © <script type="text/javascript"> document.write((new Date()).getFullYear())</script></div>
            <div class="text-center pb-1 login-footer_version">v 0.3.0.1</div>
        </form>
    </div>
</div>


<!-- =========================================================-->
<!-- All Scripts -->
<!-- ========================================================= -->
<!-- jquery -->
<script src="{{asset('assets/vendor/jquery/js/jquery-3.2.1.min.js')}}"></script>
<!-- bootstrap -->
<script src="{{asset('assets/vendor/popper/js/popper.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- simplebar scroll -->
<script src="{{asset('assets/vendor/simplebar/js/simplebar.min.js')}}"></script>
<!-- main js -->
<script src="{{asset('assets/js/main.js')}}"></script>


</body>
</html>



