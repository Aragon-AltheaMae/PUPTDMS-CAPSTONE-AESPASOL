<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Services\AiServiceManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\RateLimiter;

class ChatbotController extends Controller
{
    public function chat(Request $request, AiServiceManager $aiServiceManager)
    {
        $request->validate([
            'message' => 'required|string|max:300',
        ]);

        $wordCount = str_word_count(strip_tags($request->message));

        if ($wordCount > 60) {
            return response()->json([
                'error' => 'Message is too long. Please keep it within 60 words.',
            ], 422);
        }

        $rateKey = 'chatbot:' . ($request->user()?->id ?? $request->ip());

        if (RateLimiter::tooManyAttempts($rateKey, 12)) {
            return response()->json([
                'error' => 'You have sent too many messages. Please wait a minute before trying again.',
            ], 429);
        }

        RateLimiter::hit($rateKey, 60);

        $apiKey = config('services.openai.api_key');

        if (!$apiKey) {
            return response()->json(
                [
                    'error' => 'Missing OPENAI_API_KEY sa .env or config/services.php.',
                ],
                500,
            );
        }

        Log::info('Chatbot question', [
            'message' => $request->message,
            'context' => $request->context,
            'user_id' => Auth::id(),
        ]);

        $context = (string) $request->context;
        $isLoginPage = str_contains($context, '/login');

        $user = Auth::user();
        $role = session('impersonated_role') ?? optional($user?->role)->slug ?? 'guest';

        $patient = null;

        if ($role === 'patient') {
            $patient = Patient::with(['appointments', 'teeth', 'dentalHistory'])
                ->where('user_id', Auth::id())
                ->first();
        }

        $appointment = $patient?->appointments?->sortByDesc('created_at')->first();
        $record = $patient?->dentalHistory;

        $roleContext = match ($role) {
            'admin' => "
    User Role: Admin
    Allowed help topics:
    - Admin dashboard and analytics
    - Patient directory and patient records
    - Appointment management, reschedule, cancellation, and viewing schedules
    - Document request approval/rejection
    - Reports, inventory, clinic schedule, system settings, user management, roles and permissions

    Important:
    - Admins do not book appointments for themselves.
    - If asked how to book as a patient, explain that booking is a patient feature.
    ",

            'dentist' => "
    User Role: Dentist
    Allowed help topics:
    - Dentist dashboard and today's appointments
    - Patient profiles and dental records
    - Odontogram and treatment records
    - Walk-in patients
    - Appointment management and follow-ups
    - Clinic schedule, document requests, reports, and inventory

    Important:
    - Dentists manage appointments and patient records.
    - Dentists do not book personal patient appointments from the patient dashboard.
    ",

            'patient' => "
    User Role: Patient
    Patient Information:
    - Name: " . ($patient?->name ?? optional($user)->name ?? 'Unknown') . "
    - Latest Appointment Date: " . ($appointment->appointment_date ?? 'None') . "
    - Latest Appointment Time: " . ($appointment->appointment_time ?? 'None') . "
    - Latest Appointment Status: " . ($appointment->status ?? 'None') . "
    - Last Treatment: " . ($record->treatment ?? 'None') . "
    - Last Diagnosis: " . ($record->diagnosis ?? 'None') . "

    Allowed help topics:
    - Booking appointments
    - Own appointments
    - Own dental records and odontogram
    - Document requests
    - Clinic schedule and available dates
    ",

            default => "
    User Role: Guest/Login
    Allowed help topics:
    - Login help
    - SSO/login buttons
    - What users can do after login
    ",
        };

        $localReply = $this->getLocalSystemReply($request->message, $context, $patient, $isLoginPage, $role);

        if ($localReply) {
            return response()->json([
                'reply' => $localReply,
            ]);
        }

        if (!$this->isClinicSystemTopic($request->message, $context, $role)) {
            return response()->json([
                'reply' => "I can only assist with topics related to the PUP Taguig Dental Clinic Management System, such as appointments, records, schedules, document requests, login, reports, inventory, and patient management.",
            ]);
        }

        if (!$aiServiceManager->shouldUse('chatbot')) {
            $aiServiceManager->recordFallback('chatbot', 'Chatbot AI is disabled or offline.', [
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'reply' => 'AI assistant is temporarily unavailable. I can still help with basic navigation, login, appointments, records, and document request questions.',
            ]);
        }

        try {
            $currentContext = $context ?: 'unknown';
            $userMessage = $request->message;
            $model = trim((string) config('services.openai.chatbot_model', 'gpt-5.5'));

            $prompt = <<<PROMPT
You are the official AI assistant of the PUP Taguig Dental Clinic Management System.

{$roleContext}

Current page/context: {$currentContext}

System route guide:
Admin:
- /admin/dashboard = admin dashboard
- /admin/patient-directory = patient directory
- /admin/appointments = appointment management
- /admin/document-requests = document request management
- /admin/reports = reports
- /admin/inventory = inventory
- /admin/system-settings = system settings

Dentist:
- /dentist/dashboard = dentist dashboard
- /dentist/appointments = appointment management
- /dentist/patients = patient profiles
- /dentist/walk-in = walk-in patients
- /dentist/clinic-schedule = clinic schedule
- /dentist/document-requests = document requests
- /dentist/report = reports
- /dentist/inventory = inventory

Patient:
- /homepage = patient dashboard
- /patient/appointments = own appointments
- /book-appointment = booking page / available dates
- /record = own dental records
- /document-requests = own document requests

Answer only based on the user's role. Do not tell admins/dentists to use patient-only booking features unless explaining that it is a patient feature.
Keep answers short but complete. Use 1 to 3 complete sentences. Do not cut off mid-sentence.
If the user asks something unrelated to the PUP Taguig Dental Clinic Management System, politely refuse and redirect them to system-related topics only.

User message: {$userMessage}
PROMPT;

            $response = Http::withToken($apiKey)
                ->acceptJson()
                ->asJson()
                ->timeout(30)
                ->retry(1, 500)
                ->post('https://api.openai.com/v1/responses', [
                    'model' => $model,
                    'input' => [
                        [
                            'role' => 'user',
                            'content' => [
                                [
                                    'type' => 'input_text',
                                    'text' => $prompt,
                                ],
                            ],
                        ],
                    ],
                    'max_output_tokens' => 220,
                ]);

            if ($response->successful()) {
                $reply = $this->extractOutputText($response->json());

                $aiServiceManager->recordSuccess('chatbot', 'OpenAI chatbot response generated.', [
                    'user_id' => Auth::id(),
                ]);

                return response()->json([
                    'reply' => $reply ?: 'Sorry, walang response mula sa AI.',
                ]);
            }

            Log::warning('OpenAI chatbot request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
                'user_id' => Auth::id(),
            ]);

            $aiServiceManager->recordFailure('chatbot', 'OpenAI chatbot request failed.', [
                'status' => $response->status(),
                'user_id' => Auth::id(),
            ]);

            $aiServiceManager->recordFallback('chatbot', 'OpenAI chatbot fallback response served.', [
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'reply' => 'AI assistant is temporarily unavailable. I can still help with basic navigation, login, appointments, records, and document request questions.',
            ]);
        } catch (\Throwable $e) {
            Log::error('OpenAI chatbot exception', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);

            $aiServiceManager->recordFailure('chatbot', 'OpenAI chatbot exception.', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);

            $aiServiceManager->recordFallback('chatbot', 'OpenAI chatbot fallback response served after exception.', [
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'reply' => 'AI assistant is temporarily unavailable. I can still help with basic navigation, login, appointments, records, and document request questions.',
            ]);
        }
    }

    private function extractOutputText(array $payload): ?string
    {
        if (!empty($payload['output_text']) && is_string($payload['output_text'])) {
            return trim($payload['output_text']);
        }

        foreach (($payload['output'] ?? []) as $output) {
            foreach (($output['content'] ?? []) as $content) {
                if (isset($content['text']) && is_string($content['text']) && trim($content['text']) !== '') {
                    return trim($content['text']);
                }
            }
        }

        return null;
    }

    private function getLocalSystemReply(string $message, ?string $context = null, ?Patient $patient = null, bool $isLoginPage = false, string $role = 'guest'): ?string
    {
        $text = strtolower($message);

        if ($isLoginPage) {
            if (str_contains($text, 'hello') || str_contains($text, 'hi')) {
                return 'Hello! This is the login page. Please sign in using your account to access appointments, records, schedules, and document requests.';
            }

            if (str_contains($text, 'log in') || str_contains($text, 'login') || str_contains($text, 'sign in')) {
                return 'On the login page, enter your credentials and use the Log In button or SSO option to access the system.';
            }

            if (str_contains($text, 'sso') || str_contains($text, 'google') || str_contains($text, 'account')) {
                return 'You can use the available login method on this page to sign in and access the clinic system.';
            }

            if (str_contains($text, 'book') || str_contains($text, 'appointment') || str_contains($text, 'record') || str_contains($text, 'schedule') || str_contains($text, 'document')) {
                return 'Those features are available after login. Please sign in first to access appointments, records, schedules, and document requests.';
            }

            return 'This is the login page. You can sign in here to access appointments, records, schedules, and document requests.';
        }

        if (str_contains($text, 'hello') || str_contains($text, 'hi')) {
            $name = $patient?->name ?? optional(Auth::user())->name ?? 'there';

            return "Hello {$name}! How can I assist you today regarding appointments, dental records, or system features?";
        }

        if ($role === 'admin') {
            if (strlen(trim($text)) < 4 || !preg_match('/[aeiou]/i', $text)) {
                return 'I’m sorry, but your request is unclear. Please specify what admin feature you need help with, such as dashboard, appointments, patients, reports, inventory, or settings.';
            }
            if (str_contains($text, 'dashboard')) {
                return 'On the Admin Dashboard, you can view clinic activity summaries, system logs, GAD analytics, inventory overview, and quick links to important admin modules.';
            }
            if (str_contains($text, 'book') || str_contains($text, 'booking')) {
                return 'Admins do not book personal appointments. As admin, you can view, manage, reschedule, or cancel appointments from the Appointments page.';
            }

            if (str_contains($text, 'appointment') || str_contains($text, 'schedule')) {
                return 'Go to Appointments to view, manage, reschedule, or cancel clinic appointments. You can also check Clinic Schedule for availability rules.';
            }

            if (str_contains($text, 'patient')) {
                return 'Go to Patient Directory to search patients, view profiles, and access related dental records.';
            }

            if (str_contains($text, 'document') || str_contains($text, 'clearance')) {
                return 'Go to Document Requests to review, approve, reject, or manage patient document requests.';
            }

            if (str_contains($text, 'report') || str_contains($text, 'analytics')) {
                return 'Go to Reports to view clinic analytics, summaries, and generated reports.';
            }

            if (str_contains($text, 'inventory')) {
                return 'Go to Inventory to monitor medicine and supply stock levels.';
            }
        }

        if ($role === 'dentist') {
            if (strlen(trim($text)) < 4 || !preg_match('/[aeiou]/i', $text)) {
                return 'I’m sorry, but your request is unclear. Please specify what dentist feature you need help with, such as appointments, patients, odontogram, walk-in, reports, or inventory.';
            }
            if (str_contains($text, 'dashboard')) {
                return 'On the Dentist Dashboard, you can view today’s appointments, monthly appointment summaries, calendar schedules, GAD analytics, and supply or medicine inventory overview.';
            }
            if (str_contains($text, 'book') || str_contains($text, 'booking')) {
                return 'Dentists do not book appointments from the patient dashboard. As dentist, you can manage appointments, set follow-ups, and handle walk-in patients.';
            }

            if (str_contains($text, 'appointment') || str_contains($text, 'schedule')) {
                return 'Go to Appointments to view today’s appointments, start consultations, reschedule, cancel, or set follow-ups.';
            }

            if (str_contains($text, 'patient')) {
                return 'Go to Patients to search patient profiles, review records, and open dental information.';
            }

            if (str_contains($text, 'odontogram')) {
                return 'Open the patient profile or appointment, then use the odontogram option to view or update dental charting.';
            }

            if (str_contains($text, 'walk')) {
                return 'Go to Walk-in to search an existing patient or add a guest walk-in consultation.';
            }

            if (str_contains($text, 'report')) {
                return 'Go to Reports to view and download dentist-side clinic reports.';
            }
        }

        if ($role !== 'patient') {
            return null;
        }

        $askingLastAppointment =
            (
                str_contains($text, 'last appointment') ||
                str_contains($text, 'previous appointment') ||
                str_contains($text, 'past appointment') ||
                str_contains($text, 'last schedule') ||
                str_contains($text, 'huling appointment') ||
                str_contains($text, 'nakaraang appointment') ||
                str_contains($text, 'last appointment ko')
            );

        if ($askingLastAppointment) {
            $now = Carbon::now();

            $appointment = $patient?->appointments
                ?->filter(function ($appt) use ($now) {
                    $appointmentDateTime = Carbon::parse($appt->appointment_date . ' ' . $appt->appointment_time);

                    return $appointmentDateTime->lessThan($now)
                        || in_array($appt->status, ['completed', 'cancelled']);
                })
                ->sortByDesc(function ($appt) {
                    return $appt->appointment_date . ' ' . $appt->appointment_time;
                })
                ->first();

            if ($appointment) {
                $date = Carbon::parse($appointment->appointment_date)->format('F d, Y');
                $time = Carbon::parse($appointment->appointment_time)->format('H:i');

                return "Your last appointment was on {$date} at {$time}. Status: {$appointment->status}.";
            }

            return "You do not have any past appointment recorded in the system.";
        }

        $askingOwnAppointment =
            (
                str_contains($text, 'appointment') ||
                str_contains($text, 'appoint') ||
                str_contains($text, 'schedule') ||
                str_contains($text, 'iskedyul')
            ) &&
            (
                str_contains($text, 'my') ||
                str_contains($text, 'mine') ||
                str_contains($text, 'when') ||
                str_contains($text, 'date') ||
                str_contains($text, 'time') ||
                str_contains($text, 'do i have') ||
                str_contains($text, 'upcoming') ||
                str_contains($text, 'ko') ||
                str_contains($text, 'akin') ||
                str_contains($text, 'kailan') ||
                str_contains($text, 'oras')
            );

        if ($askingOwnAppointment) {
            $now = Carbon::now();

            $appointment = $patient?->appointments
                ?->filter(function ($appt) use ($now) {
                    $appointmentDateTime = Carbon::parse($appt->appointment_date . ' ' . $appt->appointment_time);

                    return $appointmentDateTime->greaterThanOrEqualTo($now)
                        && in_array($appt->status, ['upcoming', 'rescheduled']);
                })
                ->sortBy(function ($appt) {
                    return $appt->appointment_date . ' ' . $appt->appointment_time;
                })
                ->first();

            if ($appointment) {
                $date = Carbon::parse($appointment->appointment_date)->format('F d, Y');
                $time = Carbon::parse($appointment->appointment_time)->format('H:i');

                return "Your next appointment is on {$date} at {$time}. Status: {$appointment->status}.";
            }

            return "You do not have any upcoming appointment recorded in the system.";
        }

        if (str_contains($text, 'record') || str_contains($text, 'dental records')) {
            return 'Open the Records tab in the bottom navigation, or go to the Dental Records page to view your dental history, odontogram, treatments, and diagnosis.';
        }

        if (str_contains($text, 'odontogram')) {
            return 'You can view your odontogram on the Dental Records page. Tap Records in the bottom navigation, then look for the odontogram section.';
        }

        if (str_contains($text, 'appointment') || str_contains($text, 'book')) {
            return 'To book an appointment, tap the plus button or go to the Book Appointment page. Choose an available date and time from the calendar.';
        }

        if (str_contains($text, 'schedule') || str_contains($text, 'available')) {
            return 'You can check available appointment dates on the Book Appointment page.';
        }

        if (str_contains($text, 'document') || str_contains($text, 'clearance')) {
            return 'Go to Document Requests to request dental clearance or dental health records.';
        }

        return null;
    }

    private function isClinicSystemTopic(string $message, ?string $context = null, string $role = 'guest'): bool
    {
        $text = strtolower(trim($message));

        if ($text === '') {
            return false;
        }

        if (str_word_count($text) <= 3 && preg_match('/^(hi|hello|hey|help)$/i', $text)) {
            return true;
        }

        $allowedKeywords = [
            'appointment',
            'appointments',
            'book',
            'booking',
            'schedule',
            'clinic',
            'dental',
            'dentist',
            'patient',
            'patients',
            'record',
            'records',
            'odontogram',
            'document',
            'documents',
            'clearance',
            'report',
            'reports',
            'inventory',
            'login',
            'sign in',
            'sso',
            'dashboard',
            'walk-in',
            'walk in',
            'follow-up',
            'follow up',
            'reschedule',
            'cancel',
            'notification',
            'system',
            'medical history',
            'dental history',
            'profile',
            'session',
            'admin',
            'homepage',
            'time slot',
            'available date',
        ];

        foreach ($allowedKeywords as $keyword) {
            if (str_contains($text, $keyword)) {
                return true;
            }
        }

        if ($context && str_contains($context, '/login')) {
            return str_contains($text, 'login')
                || str_contains($text, 'sign in')
                || str_contains($text, 'sso')
                || str_contains($text, 'account');
        }

        return false;
    }
}
