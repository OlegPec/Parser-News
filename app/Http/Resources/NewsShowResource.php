<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class NewsShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'title_image' => $this->title_image,
            'generated_image' => $this->generated_image,
            'description' => $this->description,
            'detail_description' => $this->detail_description,
            'detail_images' => $this->detail_images,
            'news_channel_id' => $this->news_channel_id,
            'category' => $this->category,
            'news_url' => $this->news_url,
            'public_date' => $this->public_date,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'news_channel' => $this->news_channel,

            'in_favorites' =>  Auth::id() ? in_array(Auth::id(), $this->user->pluck('id')->toArray()) : false
//            'in_favorites' => (Auth::id() ?: null) === $this->user->id
        ];
    }
}
