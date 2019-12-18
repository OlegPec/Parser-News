<?php

namespace App\Console\Commands;

use App\Models\News;
use App\Models\NewsChannel;
use Illuminate\Console\Command;
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
//        dd($test);
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
                        $this->CreateNews($item->title, $item->description, $item->link, $item->pubDate, $key, $item->category);
//                        dd('new');
                    }
//                    dd('old');
                }
                break;
            case 2:
                $rss = simplexml_load_file($rssChannels[$key], 'SimpleXMLElement', LIBXML_NOCDATA);
                foreach ($rss->channel->item as $item){
//                    dd('dgdg');

                    if(!in_array($item->title, $news)){
                        if(preg_match('/.(png|jpg|jpeg)$/', $item->enclosure->attributes()->url)) {
                            $imgUrl = $item->enclosure->attributes()->url;
                            $preview_image = $this->CreateImage($imgUrl, $item->title);
                        }
                        $this->CreateNews($item->title, $item->description, $item->link, $item->pubDate, $key, null, $preview_image);
                        if(preg_match('/.(png|jpg|jpeg)$/', $item->enclosure->attributes()->url)) {
                            dd('ff');
                        }
                    }
//                    dd('old');
                }
                break;
        }
//        $rss = simplexml_load_file($url);
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

    private function CreateImage($url, $text){

        $width       = 626;
        $height      = 1200;
        $center_x    = $width / 2;
        $center_y    = $height / 2;
        $max_len     = 40;//60 for 30 size;//36;
        $font_size   = 50;
        $font_height = 30;//20;

        $path = 'images/news/';
        $hex = array(
//            '#cd221b',
            '#0da00c',
            '#0c1a91',
            '#cc702c',
            '#752984',
            '#60646d',
        );

        $lines = explode("\n", wordwrap($text, $max_len));
        $ys     = $center_y - ((count($lines) - 1) * $font_height);
        $img   = Image::canvas($width, $height, $hex[array_rand($hex, 1)]);
        if($url) {
            $imgIns = Image::make($url);
            $imgIns->fit(626, 872);
//            $imgIns->crop(626, 872, 0, 0);
//            $img->resize(626, 872);
            //626x872
            $imgIns->blur(10);
            $img->insert($imgIns, 'center');
        }


//        $img = Image::canvas(626, 1200, $hex[array_rand($hex, 1)]);

//        $fontSize = 50;
        $fontPath = public_path('/fonts/Roboto.ttf');


//        $textLines = $this->generateText(
//            $text,
//            700,
//            $fontSize,
//            $fontPath
//        );

        foreach ($lines as $line)
        {
            for( $x = -2; $x <= 2; $x++ ) {
                for( $y = -2; $y <= 2; $y++ ) {
                    $img->text($line, $center_x + $x, $ys + $y, function($font) use ($font_size, $fontPath) {
                        $font->file($fontPath);
                        $font->size($font_size);
                        $font->color('#ffffff'); // Glow color
                        $font->align('center');
                        $font->valign('center');
                    });
                }
            }
            $img->text($line, $center_x, $ys, function($font) use ($font_size, $fontPath){
                $font->file($fontPath);
                $font->size($font_size);
                $font->color('#000000');
                $font->align('center');
                $font->valign('center');
            });

            $ys += $font_height * 2;
        }
        /*$img->text($textLines, 20, 600, function($font) use($fontSize, $fontPath){
            $font->file($fontPath);
            $font->size($fontSize);
            $font->color('#fdf6e3');
            $font->align('center');
//            $font->valign('center');
        });*/
        $filename = md5(now()).'.png'; //Задаем имя картинке
        $img->save(public_path($path).$filename, 70);
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
