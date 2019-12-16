<?php

namespace App\Console\Commands;

use App\Models\News;
use App\Models\NewsChannel;
use Illuminate\Console\Command;
use Image;

class RssParserController extends Command
{

    protected $signature = 'RssParser';

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
//        dd($rssChannels);
        foreach ($rssChannels as $key => $value)
        switch ($key){
            case 1:
                $rss = simplexml_load_file($rssChannels[$key]);
                foreach ($rss->channel->item as $item){
                    if(!in_array($item->title, $news)){
                        $this->CreateNews($item->title, $item->description, $item->link, $item->pubDate, $key);
//                        dd('new');
                    }
//                    dd('old');
                }
                break;
            case 2:
                $rss = simplexml_load_file($rssChannels[$key], 'SimpleXMLElement', LIBXML_NOCDATA);
                foreach ($rss->channel->item as $item){
                    if(!in_array($item->title, $news)){
                        $this->CreateNews($item->title, $item->description, $item->link, $item->pubDate, $key);
//                        dd('new');
                    }
//                    dd('old');
                }
                break;
        }
//        $rss = simplexml_load_file($url);
    }

    private function CreateNews($title, $preview_description, $news_url, $public_date, $news_channel_id, $preview_image = null){
        $preview_description = mb_strimwidth($preview_description, 0, 255, "...");
        News::create([
            'title' => $title,
            'preview_description' => $preview_description,
            'preview_image' => $preview_image,
            'news_channel_id' => $news_channel_id,
            'news_url' => $news_url,
            'public_date' => $public_date
        ]);
    }

    private function CreateImage(){

    }
}
