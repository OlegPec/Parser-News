<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>

    <!-- favicons -->
    <link rel="icon" type="image/ico" href="{{asset('assets/images/favicon.ico')}}">

    <!-- =========================================================-->
    <!-- All Styles -->
    <!-- ========================================================= -->
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
    <!-- font awesome -->
{{--    <link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">--}}
<!-- simplebar scroll -->
{{--    <link rel="stylesheet" href="{{asset('assets/vendor/simplebar/css/simplebar.min.css')}}">--}}

<!-- Main Styles -->
</head>
<body>

<div class="wrapper">
    <div class="auth-box">
        <div class="auth-logo">
        </div>
        <div class="auth-desc">
            <p class="mb-0">Добро пожаловать</p>
        </div>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group mb-20">
                <label for="first_name"><strong>Имя</strong></label>
                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                       id="first_name" placeholder="Имя" value="{{old('name')}}" minlength="2"
                       {{--pattern="/[а-яА-Яa-zA-Z]/"--}}
                       required>
                @error('name')
                <div class="alert alert-dismissible alert-danger">{{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                @enderror
            </div>
            <div class="form-group mb-20">
                <label for="email"><strong>E-Mail</strong></label>
                <input class="form-control @error('email') is-invalid @enderror form-mask-4"
                       type="email" name="email" id="email" placeholder="Email" value="{{old('email')}}" required>
                @error('email')
                <div class="alert alert-dismissible alert-danger">{{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                @enderror
            </div>
            <div class="form-group mb-20">
                <label for="password"><strong>Пароль</strong></label>
                <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" placeholder="Пароль" required>
                @error('password')
                <div class="alert alert-dismissible alert-danger">{{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                @enderror
            </div>
            <div class="form-group mb-20">
                <label for="confirmPassword"><strong>Подтвердение пароля</strong></label>
                <input class="form-control" type="password" name="password_confirmation" id="confirmPassword" placeholder="Подтверждение пароля" required>
                @error('confirmPassword')
                <div class="alert alert-dismissible alert-danger">{{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                @enderror
            </div>
            <div class="form-group mt-25">
                <button class="btn btn-primary btn-shadow btn-block">Регистрация</button>
            </div>
            <div>
                <hr>
                <p class="fs-12 text-center text-light">
                    Есть аккаунт? <a href="{{route('login')}}" class="text-primary">Войдите</a>
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
{{--<script src="{{asset('assets/vendor/popper/js/popper.min.js')}}"></script>--}}
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- simplebar scroll -->
{{--<script src="{{asset('assets/vendor/simplebar/js/simplebar.min.js')}}"></script>--}}
<!-- main js -->
{{--<script src="{{asset('assets/js/main.js')}}"></script>--}}

<script src="{{asset('assets/vendor/parsley/js/parsley.min.js')}}"></script>
<!-- jquery input mask -->
<script src="{{asset('assets/vendor/inputmask/js/inputmask.bundle.min.js')}}"></script>
<script>
    // mask
    $(function(){

        // email
        $('.form-mask-4').inputmask({
            mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
            greedy: false,
            onBeforePaste: function (pastedValue, opts) {
                pastedValue = pastedValue.toLowerCase();
                return pastedValue.replace("mailto:", "");
            },
            definitions: {
                '*': {
                    validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
                    casing: "lower"
                }
            }
        });

        $('.form-mask-5').inputmask("(999) 999-9999");

    });

</script>
</body>
</html>
