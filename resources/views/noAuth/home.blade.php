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
    </style>

    <nav class="navbar navbar-dark bg-black justify-content-center">
        <a class="navbar-brand" href="{{ route('home') }}">evolnews</a>
    </nav>
{{--    <div class="container">--}}
        <div class="d-flex justify-content-between"><span>@if(Auth::user()) Привет {{ Auth::user()->name }} <a href="{{ route('logout') }}" onclick="event.preventDefault()
                document.getElementById('logout-form').submit();" class="">
                    {{ __('Выйти') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
                </form> @endif</span>
        </div>
        <div class="row mt-5 justify-content-center">
{{--            <div class="row">--}}
                @foreach($news as $element)
{{--                <div class="col-md-4 mt-3">--}}

                    <div class="card col-12 col-md-3 m-4">
                        <a href="{{ route('showNews', $element->id) }}">
{{--                            <img class="card-img-top height-img" src="{{ asset('images/news/preview/'.$element->title_image) }}" alt="Card image cap">--}}
                            @if($element->title_image)
                                <img src="{{ asset('images/news/preview/'.$element->title_image) }}" alt="Card image cap" class="img-fluid">
                            @else
                                <img src="{{ asset('images/news/default_img.svg') }}" alt="Card image cap" class="img-fluid">
                            @endif
                        </a>
                        <a href="{{ route('showNews', $element->id) }}">
                            <div class="card-body">
                                <h5 class="card-title">{!! $element->title !!}</h5>
                                <p class="card-text">{!! rtrim(mb_strimwidth($element->description, 0, 252))."..." !!}</p>
                            </div>
                        </a>
                        <div class="card-footer">
{{--                            <small class="text-muted">Last updated 3 mins ago</small>--}}
                            <small class="text-muted">{{ $element->public_date }}</small>
                        </div>
                    </div>
{{--                </div>--}}
                @endforeach
{{--            </div>--}}
        </div>
{{--    </div>--}}

@endsection
