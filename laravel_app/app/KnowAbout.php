<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KnowAbout extends Model
{
    protected $table = 'know_abouts';
    protected $fillable = ['title','image','link','description','lang'];
}
