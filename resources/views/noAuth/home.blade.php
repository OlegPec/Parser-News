@extends('layouts/default')

@section('title', 'Главная страница')
@section('description', 'Новости всего мира')

@section('content')

    <style>
        .height-img {
            height: 240px;
        }
    </style>

    <div class="container">
        <h1>Новости</h1>
        <div class="card-columns mt-5">
{{--            <div class="row">--}}
                @foreach($news as $element)
{{--                <div class="col-md-4 mt-3">--}}

                    <div class="card">
                        <a href="{{ $element->id }}">
                            <img class="card-img-top height-img" src="{{ asset('images/news/preview/'.$element->title_image) }}" alt="Card image cap">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $element->title }}</h5>
                            <p class="card-text">{{ rtrim(mb_strimwidth($element->description, 0, 252))."..." }}</p>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Last updated 3 mins ago</small>
                        </div>
                    </div>
{{--                </div>--}}
                @endforeach
{{--            </div>--}}
        </div>
    </div>

@endsection
