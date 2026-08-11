<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrowserDetection
{
    public static function detectFromRequest(Request $request): string
    {
        $provided = self::normalizeBrowserName(
            $request->input('browser_name')
                ?? $request->header('X-Browser-Name')
                ?? $request->session()->get('browser_name_hint')
        );

        if ($provided !== null) {
            return $provided;
        }

        $clientHint = self::detectFromClientHints($request->header('Sec-CH-UA'));

        if ($clientHint !== null) {
            return $clientHint;
        }

        return self::detectFromUserAgent($request->userAgent());
    }

    public static function detectFromUserAgent(?string $userAgent): string
    {
        if (blank($userAgent)) {
            return 'Browser';
        }

        return match (true) {
            Str::contains($userAgent, 'Brave/', true) => 'Brave',
            Str::contains($userAgent, 'Edg/', true) => 'Edge',
            Str::contains($userAgent, 'OPR/', true) => 'Opera',
            Str::contains($userAgent, 'Firefox/', true) => 'Firefox',
            Str::contains($userAgent, 'Chrome/', true) => 'Chrome',
            Str::contains($userAgent, 'Safari/', true) => 'Safari',
            default => 'Browser',
        };
    }

    public static function normalizeBrowserName(mixed $value): ?string
    {
        if (! is_scalar($value)) {
            return null;
        }

        $browser = trim((string) $value);

        if ($browser === '') {
            return null;
        }

        $normalized = strtolower($browser);

        return match (true) {
            str_contains($normalized, 'brave') => 'Brave',
            str_contains($normalized, 'edge') || str_contains($normalized, 'edg') => 'Edge',
            str_contains($normalized, 'opera') || str_contains($normalized, 'opr') => 'Opera',
            str_contains($normalized, 'firefox') => 'Firefox',
            str_contains($normalized, 'chrome') || str_contains($normalized, 'chromium') => 'Chrome',
            str_contains($normalized, 'safari') => 'Safari',
            default => null,
        };
    }

    public static function detectFromClientHints(?string $clientHints): ?string
    {
        if (blank($clientHints)) {
            return null;
        }

        $normalized = strtolower($clientHints);

        return match (true) {
            str_contains($normalized, '"brave"') => 'Brave',
            str_contains($normalized, '"microsoft edge"') || str_contains($normalized, '"edge"') => 'Edge',
            str_contains($normalized, '"opera"') => 'Opera',
            str_contains($normalized, '"firefox"') => 'Firefox',
            str_contains($normalized, '"google chrome"') || str_contains($normalized, '"chromium"') => 'Chrome',
            str_contains($normalized, '"safari"') => 'Safari',
            default => null,
        };
    }
}
