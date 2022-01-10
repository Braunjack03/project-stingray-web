<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfileCompanyType extends Model
{
    use HasFactory;

    protected $table = 'company_profile_company_type';

    protected $fillable = [
        'company_profile_id','company_type_id',
    ];

}
