<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','user_id','stripe_id','stripe_status','stripe_plan','quantity','trial_ends_at','ends_at'
    ];

}
