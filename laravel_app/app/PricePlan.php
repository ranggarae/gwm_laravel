<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PricePlan extends Model
{
    protected $table = 'price_plans';
    protected $fillable = ['title','url_status','price','type','icon','lang','features','btn_text','btn_url'];
}
