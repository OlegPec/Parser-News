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
//        mb_internal_encoding("UTF-8");
        //        $url = 'https://www.nasa.gov/rss/dyn/educationnews.rss';
//        $rss = simplexml_load_file($url);
//        $test = levenshtein('Карл у Клары украл караллы', '', 0, 1, 1);
//        $text = '«Мерзость нечестивая». Одни боготворят, а другие проклинают пиццу с киви 🍕🥝';
//        echo $text.'<br>';
//        $text2 = preg_replace('/\xEE[\x80-\xBF][\x80-\xBF]|\xEF[\x81-\x83][\x80-\xBF]/', '', $text);
//        $text3 = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","", $text);
//        echo $text2.'<br>';
//        $text4 = $this->removeEmojis($text);
//        echo $text4;
//        dd('dd');
        $rssChannels = NewsChannel::all()->pluck('url', 'id'); //->sortBy('id')
        $news = News::all()->pluck('title')->toArray();
        $title_image = null;
        $generated_image = null;
//        dd($rssChannels);
        foreach ($rssChannels as $key => $value)
        switch ($key){
            case 1:
                $rss = simplexml_load_file($rssChannels[$key]);
                foreach ($rss->channel->item as $item){;
                    if(!in_array($item->title, $news)){
//                        dd($item->description);
                        $generated_image = $this->CreateImage($item->title, $item->description);
                        $this->CreateNews($item->title, $item->description, $item->link, $item->pubDate, $key, $generated_image, $item->category, $title_image);
//                        dd('new');
                    }
//                    else {
//                        dd('old');
//                    }
                }
                break;
            case 2:
                $rss = simplexml_load_file($rssChannels[$key], 'SimpleXMLElement', LIBXML_NOCDATA);
                foreach ($rss->channel->item as $item){
//                    dd('dgdg');

                    if(!in_array($item->title, $news)){
                        if($item->description) {
                            if(preg_match('/.(png|jpg|jpeg)$/', $item->enclosure->attributes()->url)) {
                                $imgUrl = $item->enclosure->attributes()->url;
                                $title_image = $this->savePreview($imgUrl);
                                $generated_image = $this->CreateImage($item->title, $item->description, $imgUrl);
                            }else {
                                $generated_image = $this->CreateImage($item->title, $item->description);
                            }
                            $this->CreateNews($item->title, $item->description, $item->link, $item->pubDate, $key, $generated_image, null, $title_image);
                            $title_image = null;
                        }
                    }
//                    dd('old');
                }
                break;
            case 3:
                $rss = simplexml_load_file($rssChannels[$key], 'SimpleXMLElement', LIBXML_NOCDATA);
                foreach ($rss->channel->item as $item){
                    if(!in_array($item->title, $news)){
                        $description = trim(str_replace(['&laquo;', '&raquo;', '&nbsp;', '&quot;'], ['«', '»', ' ', '"'], $item->description));
                        if($description) {
                            $generated_image = $this->CreateImage($item->title, $description);
                            $this->CreateNews($item->title, $description, $item->link, $item->pubDate, $key, $generated_image, $item->category, $title_image);
//                            dd($item);
                        }
//                        dd('new');
                    }
                }
                break;
            case 4:
                $rss = simplexml_load_file($rssChannels[$key], 'SimpleXMLElement', LIBXML_NOCDATA);
//                dd($rss);
                foreach ($rss->channel->item as $item){
                    if(!in_array($item->title, $news)){
//                        dd($item);
                        $description = trim(str_replace('<br />', '', $item->description), " \n");
                        if(isset($item->enclosure['type']) && (strpos($item->enclosure['type'], 'image') !== false)){
                            $imgUrl = $item->enclosure['url'];
                            $title_image = $this->savePreview($imgUrl);
                            $generated_image = $this->CreateImage($item->title, $description, $imgUrl);
                        }else {
                            $generated_image = $this->CreateImage($item->title, $description);
                        }
                        $this->CreateNews($item->title, $description, $item->link, $item->pubDate, $key, $generated_image, $item->category, $title_image);
                        $title_image = null;
//                        dd('new');
                    }
                }
        }
//        $rss = simplexml_load_file($url);
        dd('complete');
    }

    function removeEmojis( $string ) {
        $string = str_replace('«', '<<', $string);
        $string = str_replace('»', '>>', $string);
        $string = str_replace( "?", "{%}", $string );
        $string  = mb_convert_encoding( $string, "ISO-8859-5", "UTF-8" );
        $string  = mb_convert_encoding( $string, "UTF-8", "ISO-8859-5" );
        $string  = str_replace( array( "?", "? ", " ?" ), array(""), $string );
        $string  = str_replace( "{%}", "?", $string );
        $string = str_replace('<<', '«', $string);
        $string = str_replace('>>', '»', $string);
        return trim( $string );
    }

    private function CreateNews($title, $description, $news_url, $public_date, $news_channel_id, $generated_image, $category = null, $title_image = null){
//        $preview_description_short = rtrim(mb_strimwidth($preview_description, 0, 252))."...";
        News::create([
            'title' => $title,
//            'preview_description' => $preview_description_short,
            'description' => $description,
            'title_image' => $title_image,
            'generated_image' => $generated_image,
            'category' => $category,
            'detail_description' => $description,
            'news_channel_id' => $news_channel_id,
            'news_url' => $news_url,
            'public_date' => $public_date
        ]);
    }

    private function wordWrapTextRu($text, $len){
        $mes = iconv("UTF-8", "cp1251", $text);
        $mes = wordwrap($mes, $len);//, "\n", 1);
        $mes = iconv("cp1251", "UTF-8", $mes);
        return $mes;
    }

    public function CreateImage($title, $description, $url = null){

        $width_canvas        = 626;
        $height_canvas       = 1200;
        $position            = 100;
        $margin              = 35;
        $padding             = 15;
        $width_img           = 596;
        $height_img          = 300;
        $max_len_title       = 35;//63;
        $font_size_title     = 30;
        $font_height_title   = 20;//20;
        $font_size_text      = 23;
        $font_height_text    = 15;
//        $max_len_text        = 80;
        $max_len_text        = 45;
        $img_path = 'images/news/generated/';
        $title = $this->removeEmojis($title);
//        $description = 'Немецкий автопроизводитель Porsche сообщил, что продажи его автомобилей в прошлом году выросли на 10%, до рекордных 281 тыс. По темпам роста продаж Porsche, самое прибыльное подразделение Volkswagen, опередил большинство мировых автопроизводителей. Основой хороших результатов Porsche стал рост продаж спортивных кроссоверов Macan и Cayenne — они выросли на 16% и 29% соответственно. «Мы оптимистичны по поводу того, что сможем поддержать высокий спрос в 2020 году»,— отметил директор по продажам Porsche Детлеф фон Платен. По его мнению, уровень продаж будет высоким благодаря введению ряда новых моделей и большому количеству заказов на электромобиль Taycan. Наибольший рост продажи Porsche показали в Европе — они увеличились на 15%, до 89 тыс. В Китае продажи выросли на 8%, до 87,8 тыс., а в США — на 7%, до 61,6 тыс. Яна Рождественская';
        $description = $this->removeEmojis($description);
//        $description = rtrim(mb_strimwidth($description, 0, 252))."...";
        $description = Str::words($description, 50, "... \n\nЧитайте продолжение по ссылке в описании.");

        $fontPathTitle = public_path('/fonts/Roboto-Bold.ttf');
        $fontPathText = public_path('/fonts/Roboto.ttf');

        $img   = Image::canvas($width_canvas, $height_canvas, '#ffffff');
        $lines_title = explode("\n", $this->wordWrapTextRu($title, $max_len_title));//, wordwrap($title, $max_len_title)); //
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
        $lines_description = explode("\n", $this->wordWrapTextRu($description, $max_len_text));//, wordwrap($description, $max_len_text));
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


    private function savePreview($preview_url){
        $img = Image::make($preview_url);
        $img_path = 'images/news/preview/';
        try {
            $img_name = bin2hex(random_bytes(16));
        } catch (\Exception $e) {
            $img_name = Str::random(32);
        }
        $filename = md5($img_name).'.png'; //Задаем имя картинке
        $img->save(public_path($img_path).$filename, 70);

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
