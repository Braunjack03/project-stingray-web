<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Auth;


class EmployerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','profile_image','current_job_title', 'short_bio', 'linkedin',
    ];

    public function getProfileImageAttribute($value)
    {
        if($value)
        return getBucketImageUrl(Auth::user()->uuid,$value,'employer');
    }


}
