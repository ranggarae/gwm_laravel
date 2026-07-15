<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gig extends Model
{
    protected $table = 'gigs';
    protected $fillable = ['title', 'slug', 'lang', 'status', 'image', 'gallery', 'description', 'faqs_title','faqs_description', 'plan_title', 'plan_price', 'plan_description', 'delivery_time', 'features','revisions','meta_tags','meta_description','category_id'];
}
