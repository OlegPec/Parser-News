<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsChannelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Коммерсантъ',
                'url' => 'https://www.kommersant.ru/RSS/news.xml',
            ],
            [
                'id' => 2,
                'name' => 'Meduza',
                'url' => 'https://meduza.io/rss/all',
            ],
        ];

        DB::table('news_channels')->insert($data);
    }
}
