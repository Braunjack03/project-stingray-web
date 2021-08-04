<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    public const EXPLEVELS =  [
        1 => 'Entry Level',
        2 => 'Mid Level',
        3 => 'Senior Level'
    ];

    public static function getExplevelID($explevel)
    {
        return array_search($explevel, self::EXPLEVELS);
    }

    public function getExplevelAttribute()
    {
        return self::EXPLEVELS[$this->attributes['explevel_id']];
    }

    public function setExplevelAttribute($value)
    {
        $explevelID = self::getExplevelID($value);
        if ($explevelID) {
            $this->attributes['explevel_id'] = $explevelID;
        }
    }

    //$table->enum('remote_type', ['Remote', 'Hybrid', 'In Office', 'Not Specified'])->default('Not Specified');

    public const REMOTETYPES =  [
        1 => 'Fully Remote',
        2 => 'Partial Remote',
        3 => 'No Remote',
        4 => 'Not Specified'
    ];

    public static function getRemotetypeID($remotetype)
    {
        return array_search($remotetype, self::REMOTETYPES);
    }

    public function getRemotetypeAttribute()
    {
        return self::REMOTETYPES[$this->attributes['remotetype_id']];
    }

    public function setRemotetypeAttribute($value)
    {
        $remotetypeID = self::getRemotetypeID($value);
        if ($remotetypeID) {
            $this->attributes['remotetype_id'] = $remotetypeID;
        }
    }
}
