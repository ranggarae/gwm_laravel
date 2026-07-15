<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    protected $table = 'jobs';
    protected $fillable = [
        'title',
        'position',
        'company_name',
        'category_id',
        'vacancy',
        'job_responsibility',
        'employment_status',
        'education_requirement',
        'experience_requirement',
        'additional_requirement',
        'job_location',
        'salary',
        'other_benefits',
        'email',
        'deadline',
        'status',
        'lang',
        'slug',
        'job_context',
        'meta_tags',
        'meta_description',
        'is_featured',
        'company_logo',
        ];

    public function category(){
        return $this->hasOne('App\JobsCategory','id','category_id');
    }
}
