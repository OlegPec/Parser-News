<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

//        echo 'Новости';
        $news = News::whereNotNull('title_image')->limit(30)->get();

        return view('noAuth.home', compact('news'));
    }
}
