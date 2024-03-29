<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:d/m/Y'
    ];
        
    protected $fillable = [
        'name','uuid','user_id','slug','website_url','year_founded','description','profile_title','featured_image_url','logo_image_url','local_employees','global_employees','mission','industry_ids','street_addr_1','street_addr_2','city','postcode','state_abbr', 'website', 'linkedin_user', 'facebook_user', 'twitter_user', 'instagram_user','lat','long',
    ];

    public function job_posts()
    {
        return $this->hasMany(JobPost::class);
    }

    public function company_types()
    {
        return $this->belongsToMany(CompanyType::class)->withTimestamps();
    }

    public function company_galleries()
    {
        return $this->hasMany(CompanyProfileGallery::class,'company_profile_id')->withTimestamps();
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class)->withTimestamps();
    }

    public function benefit_cats()
    {
        return $this->belongsToMany(BenefitCat::class)->withTimestamps();
    }


}
