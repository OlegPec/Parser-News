<?php

namespace App\Models;

use App\Models\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use UsesUuid;

    protected $fillable = ['title', 'preview_description', 'preview_image', 'news_channel_id', 'category', 'news_url', 'public_date', 'detail_description', 'generated_image'];

    public function news_channel(){
        return $this->belongsTo('App\Models\NewsChannel', 'news_channel_id', 'id');
    }
}
