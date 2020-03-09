<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

//        echo 'Новости';
        $news = News::orderBy('public_date', 'DESC')->take(30)->get(); //whereNotNull('title_image')->

        return view('noAuth.home', compact('news'));
    }
}
