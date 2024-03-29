<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfileBenefitCat extends Model
{
    use HasFactory;
    protected $table = 'benefit_cat_company_profile';
    protected $fillable = [
        'company_profile_id','benefit_cat_id'
    ];
    public function benefit_cats()
    {
        return $this->belongsTo('App\Models\BenefitCat','benefit_cat_id','id');
    }
}
