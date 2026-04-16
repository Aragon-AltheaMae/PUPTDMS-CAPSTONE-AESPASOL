<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('notif_setting')) {

    /**
     * Get notification setting value
     *
     * @param string $key
     * @param mixed $default
     * @return bool
     */
    function notif_setting(string $key, $default = true)
    {
        try {
            // Check kung may table ka for settings
            if (!DB::getSchemaBuilder()->hasTable('notification_settings')) {
                return $default;
            }

            $setting = DB::table('notification_settings')
                ->where('key', $key)
                ->value('value');

            // Convert to boolean (para kahit "1"/"0" string)
            if (is_null($setting)) {
                return $default;
            }

            return filter_var($setting, FILTER_VALIDATE_BOOLEAN);
        } catch (\Throwable $e) {
            // fallback kung may error (safe)
            return $default;
        }
    }
}