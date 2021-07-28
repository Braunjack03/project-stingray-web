<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    public const EXPLEVELS =  [
        'Entry Level' => 1,
        'Mid Level' => 2,
        'Senior Level' => 3,
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
        'Fully Remote' => 1,
        'Partial Remote' => 2,
        'No Remote' => 3,
        'Not Specified' => 4
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
