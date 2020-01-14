<?php

namespace App\Console\Commands;

use App\Models\News;
use App\Models\NewsChannel;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Image;

class RssParserController extends Command
{

    protected $signature = 'rssParser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get news';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(){
        //        $url = 'https://www.nasa.gov/rss/dyn/educationnews.rss';
//        $rss = simplexml_load_file($url);
//        $test = levenshtein('Карл у Клары украл караллы', '', 0, 1, 1);
        $rssChannels = NewsChannel::all()->pluck('url', 'id'); //->sortBy('id')
        $news = News::all()->pluck('title')->toArray();
        $preview_image = null;
//        dd($rssChannels);
        foreach ($rssChannels as $key => $value)
        switch ($key){
            case 1:
                $rss = simplexml_load_file($rssChannels[$key]);
                foreach ($rss->channel->item as $item){;
                    if(!in_array($item->title, $news)){
                        $preview_image = $this->CreateImage($item->title, $item->description);
                        $this->CreateNews($item->title, $item->description, $item->link, $item->pubDate, $key, $item->category, $preview_image);
//                        dd('new');
                    }else {
                        dd('old');
                    }
                }
                break;
            case 2:
                $rss = simplexml_load_file($rssChannels[$key], 'SimpleXMLElement', LIBXML_NOCDATA);
                foreach ($rss->channel->item as $item){
//                    dd('dgdg');

                    if(!in_array($item->title, $news)){
                        if(preg_match('/.(png|jpg|jpeg)$/', $item->enclosure->attributes()->url)) {
                            $imgUrl = $item->enclosure->attributes()->url;
                            $preview_image = $this->CreateImage($item->title, $item->description, $imgUrl);
                        }else {
                            $preview_image = $this->CreateImage($item->title, $item->description);
                        }
                        $this->CreateNews($item->title, $item->description, $item->link, $item->pubDate, $key, null, $preview_image);
                        /*if(preg_match('/.(png|jpg|jpeg)$/', $item->enclosure->attributes()->url)) {
                            dd('ff');
                        }*/
                    }
//                    dd('old');
                }
                break;
        }
//        $rss = simplexml_load_file($url);
        dd('dfgdfgh');
    }

    private function CreateNews($title, $preview_description, $news_url, $public_date, $news_channel_id, $category = null, $preview_image = null){
        $preview_description_short = rtrim(mb_strimwidth($preview_description, 0, 252))."...";
        News::create([
            'title' => $title,
            'preview_description' => $preview_description_short,
            'preview_image' => $preview_image,
            'category' => $category,
            'news_channel_id' => $news_channel_id,
            'news_url' => $news_url,
            'public_date' => $public_date
        ]);
    }

    private function CreateImage($title, $description, $url = null){

        $width_canvas        = 626;
        $height_canvas       = 1200;
        $position            = 100;
        $margin              = 35;
        $padding             = 15;
        $width_img           = 596;
        $height_img          = 300;
        $max_len_title       = 65;
        $font_size_title     = 30;
        $font_height_title   = 20;//20;
        $font_size_text      = 23;
        $font_height_text    = 15;
        $max_len_text        = 84;
        $img_path = 'images/news/';

        $fontPathTitle = public_path('/fonts/Roboto-Bold.ttf');
        $fontPathText = public_path('/fonts/Roboto.ttf');

        $img   = Image::canvas($width_canvas, $height_canvas, '#ffffff');
        $lines_title = explode("\n", wordwrap($title, $max_len_title));
//        $position = $start_position - ((count($lines) - 1) * $font_height);
        foreach ($lines_title as $line)
        {
            $img->text($line, $padding, $position, function($font) use ($font_size_title, $fontPathTitle){
                $font->file($fontPathTitle);
                $font->size($font_size_title);
                $font->color('#000000');
//                $font->align('center');
//                $font->valign('center');
            });
            $position += $font_height_title * 2;
        }
        $position -= $font_height_title * 2; //удаление последнего пробела заголовка
        if($url) {
            $position += $margin;
            $imgIns = Image::make($url);
//            $imgIns->fit(626, 872);
//            $imgIns->crop(626, 872, 0, 0);
            $imgIns->widen($width_img);
            //626x872
//            $imgIns->blur(10);
            $img->insert($imgIns, null, $padding, $position); //insert(img, 'center', x, y);
            $position += ($imgIns->height() + 20) + $margin;
        }else{
            $position = $position + $margin + 20;
        }
        $lines_description = explode("\n", wordwrap($description, $max_len_text));
//        $position = $start_position - ((count($lines) - 1) * $font_height);
        foreach ($lines_description as $line)
        {
            $img->text($line, $padding, $position, function($font) use ($font_size_text, $fontPathText){
                $font->file($fontPathText);
                $font->size($font_size_text);
                $font->color('#000000');
//                $font->align('center');
//                $font->valign('center');
            });
            $position += $font_height_text * 2;
        }
        try {
            $img_name = bin2hex(random_bytes(16));
        } catch (\Exception $e) {
            $img_name = Str::random(32);
        }
        $filename = md5($img_name).'.png'; //Задаем имя картинке
        $img->save(public_path($img_path).$filename, 70);
//        dd('dgdg');
        return $filename;
    }

//    public function generateText($text, $width, $size, $path)
//    {
//        //-- Helpers
//        $line = [];
//        $lines = [];
//        //-- Looop through words
//        foreach(explode(" ", $text) AS $word)
//        {
//            //-- Add to line
//            $line[] = $word;
//
//            //-- Create new text query
//            $im = new \Imagick();
//            $draw = new \ImagickDraw();
//            $draw->setFont($path);
//            $draw->setFontSize($size);
//            $info = $im->queryFontMetrics($draw, implode(" ", $line));
//
//            //-- Check within bounds
//            if ($info['textWidth'] >= $width)
//            {
//                //-- We have gone to far!
//                array_pop($line);
//                $lines[] = implode(" ", $line);
//                //-- Start new line
//                unset($line);
//                $line[] = $word;
//            }
//        }
//
//        //-- We are at the end of the string
//        $lines[] = implode(" ", $line);
//        return $lines;
//    }
}
