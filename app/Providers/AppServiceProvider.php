<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

        public function boot(): void
    {
        try {
            $timezone = setting('timezone', 'Asia/Manila (UTC+8)');
            $clinicName = setting('clinic_name', 'PUP Taguig Dental Clinic');
            $language = setting('language', 'English (US)');

            $timezoneMap = [
                'Asia/Manila (UTC+8)' => 'Asia/Manila',
                'UTC' => 'UTC',
            ];

            $localeMap = [
                'English (US)' => 'en',
                'Filipino' => 'fil',
            ];

            $actualTimezone = $timezoneMap[$timezone] ?? 'Asia/Manila';
            $actualLocale = $localeMap[$language] ?? 'en';

            config([
                'app.timezone' => $actualTimezone,
                'app.name' => $clinicName,
                'app.locale' => $actualLocale,
            ]);

            app()->setLocale($actualLocale);
            date_default_timezone_set($actualTimezone);

            View::share('globalClinicName', $clinicName);
        } catch (\Throwable $e) {
            //
        }
    }
}