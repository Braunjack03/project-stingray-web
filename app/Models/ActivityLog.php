<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class ActivityLog extends Model
{
    use HasFactory;

   
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','comment', 'type', 'user_ip',
    ];

    public static function addToLog($subject)
    {
        $log = [];
        $log['comment'] = $subject;
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        $log['type'] = str_replace("-"," ",Request::segment(2));
        $log['user_ip'] = Request::ip();
        ActivityLog::create($log);
    }
}
