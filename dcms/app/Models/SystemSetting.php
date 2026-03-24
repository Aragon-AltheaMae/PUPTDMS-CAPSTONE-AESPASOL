<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
    ];

    public static function getSetting(string $key, mixed $default = null): mixed
    {
        $setting = static::query()->where('key', $key)->first();

        return $setting && $setting->value !== null
            ? $setting->value
            : $default;
    }

    public static function setSetting(string $key, mixed $value, string $group = 'general'): void
    {
        if (is_array($value)) {
            $value = implode(',', $value);
        }

        static::query()->updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
            ]
        );
    }

    public static function getMany(array $keys): Collection
    {
        return static::query()
            ->whereIn('key', $keys)
            ->get()
            ->keyBy('key');
    }
}