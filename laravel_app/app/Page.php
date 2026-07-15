<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';
    protected $fillable = ['title','lang','meta_description','meta_tags','content','status','slug','meta_tags','meta_description'];
}
