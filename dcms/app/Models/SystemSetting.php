<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    public static function getSetting(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();

        return $setting && $setting->value !== null
            ? $setting->value
            : $default;
    }

    public static function setSetting(string $key, mixed $value, string $group = 'general'): void
    {
        if (is_array($value)) {
            $value = implode(',', $value);
        }

        $setting = static::firstOrNew(['key' => $key]);
        $setting->value = $value;
        $setting->group = $group;
        $setting->save();
    }
}