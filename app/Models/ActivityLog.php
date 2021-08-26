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

    public static function addToLog($subject,$type)
    {
        $log = [];
        $log['comment'] = $subject;
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        $log['type'] = $type;
        $log['user_ip'] = Request::ip();
        ActivityLog::create($log);
    }

    public static function addUnAuthorizeLogs($subject,$user_id,$type)
    {
        $log = [];
        $log['comment'] = $subject;
        $log['user_id'] = $user_id;
        $log['type'] = $type;
        $log['user_ip'] = Request::ip();
        ActivityLog::create($log);
    }
}
