<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GigsCategory extends Model
{
   protected $table = 'gigs_categories';
   protected $fillable = ['name','lang','status','icon_type','icon','img_icon'];
}
