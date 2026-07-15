<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GigMessage extends Model
{
    protected $table = 'gig_messages';
    protected $fillable = ['user_id','notify_mail','user_type','message','file','status','gig_order_id'];
}
