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
        #upload {
            /*display: none*/
        }
    </style>
    <nav class="navbar navbar-dark bg-black justify-content-center">
        <a class="navbar-brand" href="{{ route('home') }}">evolnews</a>
    </nav>
    <div class="container">
        <div class="d-flex justify-content-between"><h1></h1><span>@if(Auth::user()) Привет {{ Auth::user()->name }} <a href="{{ route('logout') }}" onclick="event.preventDefault()
                document.getElementById('logout-form').submit();" class="">
                    {{ __('Выйти') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
                </form> @endif</span>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <h4>{!! $news->title !!}</h4>
                <p class="text-center">
                    @if($news->title_image)
                        <img src="{{ asset('images/news/preview/'.$news->title_image) }}" alt="Card image cap" class="img-fluid">
                    @else
                        <img src="{{ asset('images/news/default_img.svg') }}" alt="Card image cap" class="img-fluid">
                    @endif
                </p>
                <p>{!! $news->description !!}</p>
                <a class="btn btn-dark bg-black w-100" href="{{ $news->news_url }}">Читать на {{ $news->news_channel->name }}</a>
                @if(Auth::user())
{{--                    <a href="{{ route('downloadINewsImg', $news->id) }}">Скачать сгенерированную картинку</a>--}}
                <div class="d-flex justify-content-center">
                    <a href="{{ asset('images/news/generated/'.$news->generated_image) }}" download>Скачать сгенерированную картинку</a>
                </div>
                <div class="mt-5 pb-5">
                    <form action="{{ route('uploadNewsImg', $news->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="image" id="upload">
                        {{--<label for="upload" class="btn btn-secondary">
                            Загрузить изображение
                        </label>--}}
                        <button class="btn btn-bold btn-success img-save" type="submit">Сохранить</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>

@endsection
