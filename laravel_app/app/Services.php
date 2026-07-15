<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'services';

    protected $fillable = ['title','lang','icon','image','description','categories_id','excerpt','status','slug','meta_description','meta_tags','img_icon','icon_type'];

    public function category(){
        return $this->belongsTo('App\ServiceCategory','categories_id');
    }
}
