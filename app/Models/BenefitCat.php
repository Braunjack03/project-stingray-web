<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenefitCat extends Model
{
    use HasFactory;

    public function company_profiles()
    {
        return $this->belongsToMany(CompanyProfile::class)->withTimestamps();
    }

}
