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
        'user_id','profie_image','current_job_title', 'short_bio', 'linkedin',
    ];

    public function getProfileImageAttribute($value)
    {
        if($value)
        return url('https://'.env('AWS_BUCKET').'.s3.'.env('AWS_DEFAULT_REGION').'.amazonaws.com/employer/'.Auth::user()->uuid.'/'.$value);
    }

}
