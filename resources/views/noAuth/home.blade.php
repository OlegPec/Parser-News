@extends('layouts/default')

@section('title', 'Главная страница')
@section('description', 'Новости всего мира')

@section('content')

    <style>
        .height-img {
            height: 240px;
        }
        .bg-black {
            background: #000;
        }
        .card a {
            color: black;
        }
        .card {
            /*height: 500px;*/
        }
        .card-deck .card {
            /*width: calc(100px - 20px) !important;*/
            /*min-width: 290px;*/
            min-width: 290px;
            /*margin-right: 15px;*/
            /*margin-left: 15px;*/
            margin-bottom: 20px;
        }
        .preloader-block.show {
            display: block;
        }
        .preloader-block.fade, .preloader-block.last {
            display: none;
        }
        .preloader {
            /*position: absolute;*/
            /*left: 0;*/
            /*top: 0;*/
            /*z-index: 999;*/
            width: 100%;
            height: 100%;
            text-align: center;
            justify-content: center;
            align-items: center;
            /*display: none;*/
        }
        /*.preloader-content > .spinner-border{*/
        /*    border: .25em solid #363a7b;*/
        /*    border-right-color: transparent;*/
        /*}*/
        .spinner-border {
            display: inline-block;
            width: 2.5rem;
            height: 2.5rem;
            vertical-align: text-bottom;
            border: .25em solid #363a7b;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border 0.75s linear infinite;
        }
        .preloader-block {
            /*position: relative;*/
            height: 50px;
            width: 100%;
            margin-top: -10px;
            margin-bottom: 15px;
        }
        @keyframes spinner-border {
            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <nav class="navbar navbar-dark bg-black justify-content-center">
        <a class="navbar-brand" href="{{ route('home') }}">evolnews</a>
    </nav>
    <div class="container" id="app1">
        <div class="d-flex justify-content-between"><span>@if(Auth::user()) Привет {{ Auth::user()->name }} <a href="{{ route('logout') }}" onclick="event.preventDefault()
                document.getElementById('logout-form').submit();" class="">
                    {{ __('Выйти') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
                </form> @endif</span>
        </div>
{{--        <div class="row mt-5 justify-content-center">--}}
{{--            <div class="row">--}}
{{--                @foreach($news as $element)--}}
{{--    --}}{{--                <div class="col-md-4 mt-3">--}}
{{--                    <div class="col-12 col-md-3 m-2">--}}
{{--                        <div class="card">--}}
{{--                            <a href="{{ route('showNews', $element->id) }}">--}}
{{--    --}}{{--                            <img class="card-img-top height-img" src="{{ asset('images/news/preview/'.$element->title_image) }}" alt="Card image cap">--}}
{{--                                @if($element->title_image)--}}
{{--                                    <img src="{{ asset('images/news/preview/'.$element->title_image) }}" alt="Card image cap" class="card-img-top img-fluid">--}}
{{--    --}}{{--                                @else--}}
{{--    --}}{{--                                    <img src="{{ asset('images/news/default_img.svg') }}" alt="Card image cap" class="card-img-top img-fluid">--}}
{{--                                @endif--}}
{{--                            </a>--}}
{{--                            <a href="{{ route('showNews', $element->id) }}">--}}
{{--                                <div class="card-body">--}}
{{--                                    <h5 class="card-title">{!! $element->title !!}</h5>--}}
{{--                                    <p class="card-text">{!! rtrim(mb_strimwidth($element->description, 0, 252))."..." !!}</p>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                            <div class="card-footer">--}}
{{--    --}}{{--                            <small class="text-muted">Last updated 3 mins ago</small>--}}
{{--                                <small class="text-muted">{{ $element->public_date }}</small>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}
        <card :news="{{ $news }}"></card>
    </div>

@endsection


{{--
<div class="card-deck mt-5">
    <div class="row">
        @foreach($news as $element)
            <div class="card">
                <a href="{{ route('showNews', $element->id) }}">
                    @if($element->title_image)
                        <img src="{{ asset('images/news/preview/'.$element->title_image) }}" alt="Card image cap" class="card-img-top img-fluid">
                    @endif
                </a>
                <div class="card-body">
                    <a href="{{ route('showNews', $element->id) }}">
                        <h5 class="card-title">{!! $element->title !!}</h5>
                        <p class="card-text">{!! rtrim(mb_strimwidth($element->description, 0, 252))."..." !!}</p>
                    </a>
                </div>
                <div class="card-footer">
                    <small class="text-muted">{{ $element->public_date }}</small>
                </div>
            </div>
        @endforeach
    </div>
</div>
--}}
