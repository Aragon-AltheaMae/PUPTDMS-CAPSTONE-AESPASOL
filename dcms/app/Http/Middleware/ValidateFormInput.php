<?php

namespace App\Http\Middleware;

use App\Helpers\AuditLogger;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ValidateFormInput
{
    private const CONTACT_FIELD_PATTERN = '/(^|_)(phone|mobile|contact_number|contact_no|emergency_number|emergency_contact_no)($|_)/i';

    private const SKIPPED_FIELD_PATTERN = '/(^|\.|_)(password|password_confirmation|_token|_method|csrf|signature|file|image|photo|attachment|odontogram_data)($|\.|_)/i';

    /**
     * Reject form payloads that contain executable/script-like text or invalid contact numbers.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->shouldValidate($request)) {
            return $next($request);
        }

        $errors = new MessageBag();
        $suspiciousFields = [];
        $this->validatePayload($request->except(array_keys($request->allFiles())), $errors, $suspiciousFields);

        if ($suspiciousFields !== []) {
            AuditLogger::log(
                'tampering_detected',
                'security',
                sprintf(
                    'Suspicious payload blocked on %s for field(s): %s',
                    $request->path(),
                    implode(', ', array_unique($suspiciousFields))
                )
            );
        }

        if ($errors->count() > 0) {
            throw ValidationException::withMessages($errors->toArray());
        }

        return $next($request);
    }

    private function shouldValidate(Request $request): bool
    {
        return in_array($request->method(), ['POST', 'PUT', 'PATCH'], true);
    }

    private function validatePayload(array $payload, MessageBag $errors, array &$suspiciousFields, string $prefix = ''): void
    {
        foreach ($payload as $key => $value) {
            $field = $prefix === '' ? (string) $key : $prefix . '.' . $key;

            if ($this->shouldSkipField($field)) {
                continue;
            }

            if (is_array($value)) {
                $this->validatePayload($value, $errors, $suspiciousFields, $field);
                continue;
            }

            if (!is_string($value)) {
                continue;
            }

            $trimmed = trim($value);

            if ($trimmed === '') {
                continue;
            }

            if ($this->isContactField($field)) {
                $digitsOnly = preg_replace('/\D/', '', $trimmed);

                if (!preg_match('/^[\d\s()+-]+$/', $trimmed) || !preg_match('/^\d{11}$/', $digitsOnly)) {
                    $errors->add($field, 'Contact number must be exactly 11 digits.');
                }
            }

            if ($this->containsUnsafeText($trimmed)) {
                $errors->add($field, 'Please enter readable text only. Scripts and SQL-like input are not allowed.');
                $suspiciousFields[] = $field;
            }
        }
    }

    private function shouldSkipField(string $field): bool
    {
        return preg_match(self::SKIPPED_FIELD_PATTERN, $field) === 1;
    }

    private function isContactField(string $field): bool
    {
        $lastSegment = Arr::last(explode('.', $field));

        return preg_match(self::CONTACT_FIELD_PATTERN, $lastSegment) === 1;
    }

    private function containsUnsafeText(string $value): bool
    {
        $decoded = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $patterns = [
            '/<\s*\/?\s*script\b/i',
            '/<\s*(iframe|object|embed|svg|math|link|meta|style)\b/i',
            '/\bon[a-z]+\s*=/i',
            '/\bjavascript\s*:/i',
            '/\bdata\s*:\s*text\/html/i',
            '/(?:^|[\s\'"`])or\s+1\s*=\s*1(?:$|[\s;#\-\)])/i',
            '/(?:^|[\s\'"`])or\s+[\'"]?1[\'"]?\s*=\s*[\'"]?1[\'"]?(?:$|[\s;#\-\)])/i',
            '/;\s*(drop|delete|insert|update|alter|truncate)\s+/i',
            '/--\s*$/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $decoded) === 1) {
                return true;
            }
        }

        return false;
    }
}
