<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Auth;


class JobSeekerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','profie_image','current_job_title', 'short_bio', 'linkedin', 'github', 'twitter','current_resume',
    ];

    public function getProfileImageAttribute($value)
    {
        if($value)
        return url('https://'.env('AWS_BUCKET').'.s3.'.env('AWS_DEFAULT_REGION').'.amazonaws.com/'.Auth::user()->uuid.'/'.$value);
    }

    public function getCurrentResumeAttribute($value)
    {
        if($value)
        return url('https://'.env('AWS_BUCKET').'.s3.'.env('AWS_DEFAULT_REGION').'.amazonaws.com/'.Auth::user()->uuid.'/'.$value);
    }
}
