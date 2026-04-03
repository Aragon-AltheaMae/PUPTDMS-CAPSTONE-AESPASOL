<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class FlssService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = rtrim((string) env('FLSS_BASE_URL', ''), '/');
        $this->apiKey = (string) env('FLSS_HMAC_SECRET', '');
    }

    protected function generateSignature(
        string $method,
        string $url,
        string $body,
        string $timestamp,
        string $nonce = ''
    ): string {
        $message = $method . '|' . $url . '|' . $body . '|' . $timestamp . '|' . $nonce;

        return hash_hmac('sha256', $message, $this->apiKey);
    }

    /**
     * @return array<string, string>
     */
    protected function buildHeaders(
        string $method,
        string $url,
        string $body = '',
        string $nonce = ''
    ): array {
        $timestamp = (string) time();
        $signature = $this->generateSignature($method, $url, $body, $timestamp, $nonce);

        return [
            'X-HMAC-Signature' => $signature,
            'X-HMAC-Timestamp' => $timestamp,
            'X-HMAC-Nonce' => $nonce,
            'Accept' => 'application/json',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function parseResponse(Response $response): array
    {
        $json = $response->json();

        if (is_array($json)) {
            return $json;
        }

        return [
            'raw' => (string) $response->body(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function healthCheck(): array
    {
        $method = 'GET';
        $url = $this->baseUrl . '/health';
        $body = '';
        $nonce = '';

        /** @var Response $response */
        $response = Http::withHeaders(
            $this->buildHeaders($method, $url, $body, $nonce)
        )->timeout(10)->get($url);

        $response->throw();

        return $this->parseResponse($response);
    }

    /**
     * @return array<string, mixed>
     */
    public function getFacultyProfiles(): array
    {
        $method = 'GET';
        $url = $this->baseUrl . '/faculty-profiles';
        $body = '';
        $nonce = '';

        $headers = $this->buildHeaders($method, $url, $body, $nonce);

        /** @var Response $response */
        $response = Http::withHeaders($headers)->timeout(10)->get($url);

        return [
            'request_url' => $url,
            'request_headers' => $headers,
            'status' => $response->status(),
            'body' => $this->parseResponse($response),
        ];
    }
}