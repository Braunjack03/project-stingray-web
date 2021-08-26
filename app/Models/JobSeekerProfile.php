<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSeekerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','profie_image','current_job_title', 'short_bio', 'linkedin', 'github', 'twitter','current_resume',
    ];
}
