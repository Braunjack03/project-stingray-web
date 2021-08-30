<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;


class JobSeekerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','profie_image','current_job_title', 'short_bio', 'linkedin', 'github', 'twitter','current_resume',
    ];

    public function getProfileImageAttribute($value)
    {
        return url('uploads/public-candidate-assets/'.$value);
    }

    public function getCurrentResumeAttribute($value)
    {
        return url('uploads/public-candidate-assets/'.$value);
    }
}
