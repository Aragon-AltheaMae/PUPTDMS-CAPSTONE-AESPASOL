<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StudentApiService
{
    protected string $baseUrl;
    protected string $tokenUrl;
    protected string $clientId;
    protected string $clientSecret;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.ogos.base_url'), '/');
        $this->tokenUrl = config('services.ogos.token_url');
        $this->clientId = config('services.ogos.client_id');
        $this->clientSecret = config('services.ogos.client_secret');
    }

    public function getAccessToken(): string
    {
        $response = Http::acceptJson()
            ->asJson()
            ->post($this->tokenUrl, [
                'clientId' => $this->clientId,
                'clientSecret' => $this->clientSecret,
            ]);

        if (! $response->successful()) {
            Log::error('Student API token request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new Exception('Failed to get student API access token.');
        }

        $data = $response->json();
        $accessToken = $data['data']['accessToken'] ?? null;

        if (! $accessToken) {
            Log::error('Student API token missing in response', [
                'response' => $data,
            ]);

            throw new Exception('Student API access token not found.');
        }

        return $accessToken;
    }

    public function getStudentByEmail(string $email): array
    {
        $token = $this->getAccessToken();

        $response = Http::acceptJson()
            ->withToken($token)
            ->get($this->baseUrl . '/integrations/students/profile', [
                'email' => $email,
            ]);

        if (! $response->successful()) {
            Log::error('Student fetch by email failed', [
                'email' => $email,
                'url' => $this->baseUrl . '/integrations/students/profile',
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new Exception('Failed to fetch student by email.');
        }

        return $response->json();
    }

   public function getPersonalInfoByStudentNumber(string $studentNumber): array
{
    $token = $this->getAccessToken();

    $url = $this->baseUrl . '/integrations/students/' . urlencode($studentNumber) . '/personal-info';

    Log::info('DEBUG Personal Info Request', [
        'student_number' => $studentNumber,
        'url' => $url,
    ]);

    $response = Http::acceptJson()
        ->withToken($token)
        ->get($url);

    Log::info('DEBUG Personal Info Response', [
        'student_number' => $studentNumber,
        'url' => $url,
        'status' => $response->status(),
        'body' => $response->body(),
    ]);

    if (! $response->successful()) {
        throw new Exception('Failed to fetch student personal info.');
    }

    return $response->json();
}
}