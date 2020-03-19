<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Console\Commands\RssParserController;
use Image;


class NewsController extends Controller
{
    /*public function show($id){
        $news = News::find($id);
        $news->load('news_channel');

        return view('noAuth.news.show', compact('news'));
    }*/

    public function show($id){
        $news = News::find($id);
        $news->load('news_channel');

//        return view('noAuth.news.show', compact('news'));
        return response()->json(['success' => true, 'result' => $news]);
    }

    /*public function downloadImg($id) {
        $news = News::find($id);
        $img = $news->generated_image;

        $file = asset('images/news/generated'.$img);

        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$file");
        header("Content-Type: application/png");
        header("Content-Transfer-Encoding: binary");

        readfile($file);
    }*/

    public function uploadImg($id, Request $request){

        $news = News::find($id);

        $messages = [
            'image.mimes' => 'Неверный тип изображения.',
            'image.max' => 'Максимайльный размер загружаемого изображения 4Мб.',
            'image.required' => 'Изображение обязательно',
        ];

        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpeg,png|max:4096'    //Какие типы разрешены и минимальный размер
        ], $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['error' => $errors->first('image')]); //Возвращаем текст если валидация не прошла
        }

        $path = 'images/news/preview/';
        $path_generated = 'images/news/generated/';


        try {
            $img_name = bin2hex(random_bytes(16));
        } catch (\Exception $e) {
            $img_name = Str::random(32);
        }

        $image = $request->file('image');
        $img = Image::make($request->file('image'));

        $filename = md5($img_name).'.'.$image->getClientOriginalExtension(); //Задаем имя картинке
        $img->save(public_path($path).$filename, 70);

        $old_image = $news->title_image;
        $old_image_generate = $news->generated_image;
        $news->title_image = $filename;


        $rss = new RssParserController;
        $img_generate = $rss->CreateImage($news->title, $news->description, $image);
        $news->generated_image = $img_generate;

        $news->save();

        unlink(public_path($path_generated . $old_image_generate));
        if($old_image) {
            unlink(public_path($path . $old_image));
        }

        return back()->with('success', false);
    }

}
