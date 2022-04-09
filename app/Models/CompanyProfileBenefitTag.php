<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfileBenefitCat extends Model
{
    use HasFactory;

    public function benefit_cats()
    {
        return $this->belongsToMany(BenefitCat::class)->withTimestamps();
    }
}
