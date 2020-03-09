<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

//        echo 'Новости';
        $news = News::orderBy('public_date', 'DESC')->skip(0)->take(30)->get(); //whereNotNull('title_image')->

        return view('noAuth.home', compact('news'));
    }

    public function getNews(Request $request){
//        dd($request->page);
        $count_skip = $request->page * 30;
        $news = News::orderBy('public_date', 'DESC')->skip($count_skip)->take(30)->get();

        return response()->json([
            'success' => true,
            'result' => $news
        ]);
    }
}
