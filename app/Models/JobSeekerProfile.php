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
        'user_id','profile_image','current_job_title', 'short_bio', 'linkedin', 'github', 'twitter','current_resume',
    ];



    protected $casts = [
        'created_at' => 'datetime:d/m/Y'
    ];


    public function getProfileImageAttribute($value)
    {
        if($value)
        return getBucketImageUrl(Auth::user()->uuid,$value,'');
    }

    public function getCurrentResumeAttribute($value)
    {
        if($value)
        return getBucketImageUrl(Auth::user()->uuid,$value,'');
    }
}
