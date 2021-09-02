<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','description','profile_title','local_employees','global_employees','mission','street_addr_1','street_addr_2','city','postcode','state_abbr', 'website', 'linkedin_user', 'facebook_user', 'twitter_user','lat','long',
    ];

    public function job_posts()
    {
            return $this->hasMany(JobPost::class);
    }
}
