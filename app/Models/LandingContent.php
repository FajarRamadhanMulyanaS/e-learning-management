<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingContent extends Model
{
    protected $fillable = ['key', 'value'];

    public static function getValue($key, $default = '')
    {
        return optional(self::where('key', $key)->first())->value ?? $default;
    }
}
