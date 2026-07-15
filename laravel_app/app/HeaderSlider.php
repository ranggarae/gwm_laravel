<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeaderSlider extends Model
{
    protected $table = 'header_sliders';
    protected $fillable = ['title','lang','description','btn_01_status','btn_01_text','btn_01_url','image'];
}
