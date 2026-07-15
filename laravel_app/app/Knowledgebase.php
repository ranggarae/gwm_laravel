<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Knowledgebase extends Model
{
    protected $table = 'knowledgebases';
    protected $fillable = ['title','status','topic_id','content','views','lang','slug','meta_description','meta_tags'];

    public function topic(){
        return $this->hasOne('App\KnowledgebaseTopic','id','topic_id');
    }
}
