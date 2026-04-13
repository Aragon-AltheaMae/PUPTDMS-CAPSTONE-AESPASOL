<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExternalAdminAccess;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ExternalAdminController extends Controller
{
    /**
     * Show Assign CMS Access page.
     */
    public function index(): View
    {
        return view('admin.assign-cms-access');
    }

    /**
     * Save CMS access to local database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'external_admin_id' => 'required|string|max:255',
            'fname' => 'nullable|string|max:255',
            'lname' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'office' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'age' => 'nullable|integer',
            'gender' => 'nullable|string|max:50',
            'contact_number' => 'nullable|string|max:50',
            'cms_role' => 'required|in:admin,patient,dentist',
            'cms_status' => 'required|in:active,inactive',
        ]);

        try {
            ExternalAdminAccess::updateOrCreate(
                ['external_admin_id' => $validated['external_admin_id']],
                [
                    'fname' => $validated['fname'] ?? null,
                    'lname' => $validated['lname'] ?? null,
                    'email' => $validated['email'] ?? null,
                    'office' => $validated['office'] ?? null,
                    'address' => $validated['address'] ?? null,
                    'age' => $validated['age'] ?? null,
                    'gender' => $validated['gender'] ?? null,
                    'contact_number' => $validated['contact_number'] ?? null,
                    'has_cms_access' => true,
                    'cms_role' => $validated['cms_role'],
                    'cms_status' => $validated['cms_status'],
                ]
            );

            return redirect()
                ->route('admin.assign-cms-access')
                ->with('success', 'CMS access saved successfully.');
        } catch (\Throwable $e) {
            Log::error('Failed to save CMS access', [
                'error' => $e->getMessage(),
                'data' => $validated,
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to save access. Please try again.');
        }
    }

    /**
     * Get all admins / search admins from OCMS API.
     *
     * Supported query params:
     * - search
     * - admin_id
     * - email
     * - email_address
     * - access_level
     * - role
     */
    public function search(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'admin_id' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'email_address' => 'nullable|string|max:255',
            'access_level' => 'nullable|string|max:255',
            'role' => 'nullable|string|max:255',
        ]);

        try {
            $baseUrl = rtrim((string) env('OCMS_EXTERNAL_API_URL'), '/');
            $url = $baseUrl . '/external/admins';

            /** @var array<string, string> $query */
            $query = array_filter([
                'search' => $validated['search'] ?? null,
                'admin_id' => $validated['admin_id'] ?? null,
                'email' => $validated['email'] ?? null,
                'email_address' => $validated['email_address'] ?? null,
                'access_level' => $validated['access_level'] ?? null,
                'role' => $validated['role'] ?? null,
            ], static fn ($value): bool => !is_null($value) && $value !== '');

            /** @var Response $response */
            $response = Http::timeout(15)
                ->acceptJson()
                ->withHeaders([
                    'X-External-Api-Key' => (string) env('OCMS_EXTERNAL_API_KEY'),
                ])
                ->get($url, $query);

            if ($response->failed()) {
                Log::error('OCMS external admin search failed', [
                    'url' => $url,
                    'query' => $query,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to fetch admin records from OCMS.',
                ], $response->status());
            }

            /** @var array<string, mixed> $payload */
            $payload = $response->json();

            /** @var Collection<int, array<string, mixed>> $records */
            $records = collect($payload['data'] ?? []);

            $mapped = $records->map(
                /**
                 * @param array<string, mixed> $item
                 * @return array<string, mixed>
                 */
                function (array $item): array {
                    $fname = trim((string) ($item['first_name'] ?? ''));
                    $lname = trim((string) ($item['last_name'] ?? ''));
                    $fullName = trim((string) ($item['name'] ?? trim($fname . ' ' . $lname)));

                    return [
                        'admin_id' => $item['admin_id'] ?? null,
                        'fname' => $fname,
                        'lname' => $lname,
                        'full_name' => $fullName,
                        'email' => $item['email'] ?? '',
                        'office' => $item['office'] ?? '',
                        'address' => $item['address'] ?? '',
                        'age' => $item['age'] ?? null,
                        'gender' => $item['gender'] ?? '',
                        'birthday' => $item['birthday'] ?? null,
                        'civil_status' => $item['civil_status'] ?? '',
                        'access_level' => $item['access_level'] ?? '',
                        'contact_number' => $item['emergency_contact_no'] ?? '',
                        'emergency_contact_person' => $item['emergency_contact_person'] ?? '',
                        'last_updated' => $item['last_updated'] ?? null,
                    ];
                }
            )->values();

            return response()->json([
                'success' => true,
                'data' => $mapped,
            ]);
        } catch (\Throwable $e) {
            Log::error('OCMS external admin search exception', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to connect to OCMS external admin system.',
            ], 500);
        }
    }

    /**
     * Get single admin by admin_id from OCMS API.
     *
     * @param string|int $adminId
     */
    public function show($adminId): JsonResponse
    {
        try {
            $baseUrl = rtrim((string) env('OCMS_EXTERNAL_API_URL'), '/');
            $url = $baseUrl . '/external/admins/' . urlencode((string) $adminId);

            /** @var Response $response */
            $response = Http::timeout(15)
                ->acceptJson()
                ->withHeaders([
                    'X-External-Api-Key' => (string) env('OCMS_EXTERNAL_API_KEY'),
                ])
                ->get($url);

            if ($response->failed()) {
                Log::error('OCMS external admin fetch failed', [
                    'admin_id' => $adminId,
                    'url' => $url,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to fetch selected admin record.',
                ], $response->status());
            }

            /** @var array<string, mixed> $item */
            $item = $response->json('data', []);

            $fname = trim((string) ($item['first_name'] ?? ''));
            $lname = trim((string) ($item['last_name'] ?? ''));
            $fullName = trim((string) ($item['name'] ?? trim($fname . ' ' . $lname)));

            return response()->json([
                'success' => true,
                'data' => [
                    'admin_id' => $item['admin_id'] ?? null,
                    'fname' => $fname,
                    'lname' => $lname,
                    'full_name' => $fullName,
                    'email' => $item['email'] ?? '',
                    'office' => $item['office'] ?? '',
                    'address' => $item['address'] ?? '',
                    'age' => $item['age'] ?? null,
                    'gender' => $item['gender'] ?? '',
                    'birthday' => $item['birthday'] ?? null,
                    'civil_status' => $item['civil_status'] ?? '',
                    'access_level' => $item['access_level'] ?? '',
                    'contact_number' => $item['emergency_contact_no'] ?? '',
                    'emergency_contact_person' => $item['emergency_contact_person'] ?? '',
                    'last_updated' => $item['last_updated'] ?? null,
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('OCMS external admin fetch exception', [
                'admin_id' => $adminId,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to connect to OCMS external admin system.',
            ], 500);
        }
    }
}