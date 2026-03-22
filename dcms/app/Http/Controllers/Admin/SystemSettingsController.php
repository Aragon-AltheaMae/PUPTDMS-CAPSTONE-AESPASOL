<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingsController extends Controller
{
    public function index()
    {
        $settings = SystemSetting::all()->keyBy('key');

        return view('admin.system-settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $groups = [
            'general' => [
                'language',
                'timezone',
                'date_format',
                'time_format',
                'maintenance_mode',
                'debug_mode',
                'show_appt_counter',
            ],

            'clinic' => [
                'clinic_name',
                'contact_number',
                'email_address',
                'address',
                'operating_since',
                'accreditation_no',
                'description',
            ],

            'notifications' => [
                'notif_new_appointment',
                'notif_cancellation',
                'notif_document_request',
                'notif_reminder_24h',
                'notif_confirmation',
                'notif_followup',
                'notif_channels',
            ],

            'security' => [
                'session_timeout',
                'max_login_attempts',
                'lockout_duration',
                'min_password_length',
                'two_factor_auth',
                'force_https',
                'log_failed_logins',
                'force_password_change',
                'password_requirements',
            ],

            'email' => [
                'smtp_host',
                'smtp_port',
                'smtp_encryption',
                'smtp_username',
                'smtp_password',
                'mail_from_name',
                'mail_from_address',
            ],

            'backup' => [
                'backup_frequency',
                'backup_retention_days',
                'backup_storage',
                'backup_time',
                'auto_backup_enabled',
                'backup_include_files',
                'backup_encrypt',
            ],
        ];

        foreach ($groups as $group => $keys) {
            foreach ($keys as $key) {
                $value = $request->input($key);

                if (is_array($value)) {
                    $value = implode(',', $value);
                } elseif (is_null($value)) {
                    $value = '0';
                }

                SystemSetting::setSetting($key, $value, $group);
            }
        }

        return redirect()
            ->route('admin.system_settings')
            ->with('success', 'Settings saved successfully.');
    }
}