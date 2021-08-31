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
        return url('https://public-candidate-assets.s3.us-east-2.amazonaws.com/'.$value);
    }

    public function getCurrentResumeAttribute($value)
    {
        if($value)
        return url('https://public-candidate-assets.s3.us-east-2.amazonaws.com/'.$value);
    }
}
