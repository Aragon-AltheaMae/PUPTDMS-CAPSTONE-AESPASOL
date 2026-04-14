<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FacultyApiService
{
    private string $baseUrl;
    private string $secret;

    public function __construct()
    {
        $this->baseUrl = rtrim((string) env('FLSS_BASE_URL', ''), '/');
        $this->secret = (string) env('FLSS_HMAC_SECRET', '');
    }

    public function getFaculties(): array
    {
        try {
            if (empty($this->baseUrl) || empty($this->secret)) {
                Log::error('Faculty API config missing.', [
                    'FLSS_BASE_URL' => $this->baseUrl,
                    'FLSS_HMAC_SECRET_exists' => !empty($this->secret),
                ]);

                return [];
            }

            $method = 'GET';
            $url = $this->baseUrl . '/faculty-profiles';
            $body = '';
            $timestamp = (string) time();
            $nonce = '';

            $signature = $this->generateSignature(
                $method,
                $url,
                $body,
                $timestamp,
                $nonce
            );

            $response = Http::withHeaders([
                'X-HMAC-Signature' => $signature,
                'X-HMAC-Timestamp' => $timestamp,
                'X-HMAC-Nonce'     => $nonce,
            ])->timeout(15)->get($url);

            if ($response->successful()) {
                $json = $response->json();

                return is_array($json) ? ($json['faculties'] ?? []) : [];
            }

            Log::error('Faculty API request failed.', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return [];
        } catch (\Throwable $e) {
            Log::error('Faculty API error.', [
                'message' => $e->getMessage(),
            ]);

            return [];
        }
    }

    private function generateSignature(
        string $method,
        string $url,
        string $body,
        string $timestamp,
        string $nonce
    ): string {
        $message = $this->buildMessage($method, $url, $body, $timestamp, $nonce);

        return hash_hmac('sha256', $message, $this->secret);
    }

    private function buildMessage(
        string $method,
        string $url,
        string $body,
        string $timestamp,
        string $nonce
    ): string {
        return $method . '|' . $url . '|' . $body . '|' . $timestamp . '|' . $nonce;
    }
}