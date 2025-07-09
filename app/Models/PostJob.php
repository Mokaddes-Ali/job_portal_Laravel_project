<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;
use App\Models\JobType;

class PostJob extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'title', 'category_id', 'job_type_id', 'job_nature', 'vacancy', 'salary', 'location',
        'description', 'benefits', 'responsibility', 'qualifications', 'keywords',
        'company_name', 'company_location', 'website'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }
}
