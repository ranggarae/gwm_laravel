<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupportInfo extends Model
{
    protected $table = 'support_infos';
    protected $fillable = ['icon','title','lang','details'];
}
