<?php

namespace App\Models;

use App\Models\Traits\UsesUuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use UsesUuid;

    protected $fillable = ['title', 'description', 'title_image', 'news_channel_id', 'category', 'news_url', 'public_date', 'detail_description', 'generated_image'];

    public function news_channel()
    {
        return $this->belongsTo('App\Models\NewsChannel', 'news_channel_id', 'id');
    }

    public function user()
    {
        return$this->belongsToMany('App\User', 'user_m2m_news');
    }

    protected function getPublicDateAttribute($value)
    {
       return Carbon::parse($value)->formatLocalized('%e %B, %Y');
    }
}
