<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

class Blog extends Model  implements Feedable
{
    protected $table = 'blogs';
    protected $fillable = ['title','lang','excerpt','content','blog_categories_id','tags','image','user_id','author','status','meta_tags','slug','meta_description'];

    public function category(){
        return $this->belongsTo('App\BlogCategory','blog_categories_id');
    }
    public function user(){
        return $this->belongsTo('App\Admin','user_id');
    }

    public function toFeedItem()
    {
        return FeedItem::create([
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->excerpt,
            'updated' => $this->updated_at,
            'link' => route('frontend.blog.single',$this->slug),
            'author' =>!empty($this->author) ? $this->author : 'Anonymous',
        ]);
    }

    public static function getAllFeedItems()
    {
        return Blog::all();
    }
}
