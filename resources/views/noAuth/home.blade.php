@extends('layouts/default')

@section('title', 'Главная страница')
@section('description', 'Новости всего мира')

@section('content')

    <div id="app">
        <app :news="{{ $news }}"></app>
    </div>

@endsection

