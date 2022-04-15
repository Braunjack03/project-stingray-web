<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfileGallery extends Model
{
    use HasFactory;

    protected $table = 'company_profile_gallery';

    protected $fillable = [
        'company_profile_id','image',
    ];
    

}
