<?php

namespace App\Services;

use App\Models\DocumentTemplate;
use App\Models\DocumentTemplateField;
use App\Models\DailyTreatmentRecord;
use App\Models\DentalServiceRecord;
use App\Models\Inventory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DocumentTemplateRenderer
{
    public function render(DocumentTemplate $template, array $context = []): string
    {
        $content = (string) $template->content;

        if ($content === '') {
            return '';
        }

        $context = $this->buildTemplateContext($template, $context);

        $fields = DocumentTemplateField::query()
            ->where('document_type', $template->document_type)
            ->get()
            ->keyBy('field_key');

        return preg_replace_callback('/\{\{\s*([a-zA-Z0-9_]+)\s*\}\}/', function (array $matches) use ($fields, $context) {
            $fieldKey = $matches[1];
            $field = $fields->get($fieldKey);

            $value = $this->resolveValue($fieldKey, $field, $context);

            return e((string) $value);
        }, $content) ?? $content;
    }

    public function renderForPreview(DocumentTemplate $template): string
    {
        return $this->render($template, []);
    }

    private function buildTemplateContext(DocumentTemplate $template, array $context): array
    {
        if ($template->document_type === 'dental_cases') {
            return array_merge($this->buildDentalCasesContext(), $context);
        }

        if ($template->document_type === 'gad_report') {
            return array_merge($this->buildGadReportContext(), $context);
        }

        if ($template->document_type === 'dental_supplies_inventory') {
            return array_merge($this->buildDentalSuppliesInventoryContext(), $context);
        }

        if ($template->document_type === 'medicine_inventory') {
            return array_merge($this->buildMedicineInventoryContext(), $context);
        }

        if ($template->document_type === 'daily_treatment_record') {
            return array_merge($this->buildDailyTreatmentRecordContext(), $context);
        }

        if ($template->document_type === 'dental_services') {
            return array_merge($this->buildDentalServicesContext(), $context);
        }

        return $context;
    }

    private function buildDentalCasesContext(): array
    {
        $currentMonth = now();
        $clinicName = setting('clinic_name', 'Taguig Dental Clinic');

        $records = DailyTreatmentRecord::query()
            ->whereYear('treatment_date', $currentMonth->year)
            ->whereMonth('treatment_date', $currentMonth->month)
            ->select('office_type', 'treatment_done', DB::raw('COUNT(*) as total'))
            ->groupBy('office_type', 'treatment_done')
            ->orderByDesc('total')
            ->get();

        $groups = [
            'students' => [
                'filter' => fn ($row) => $row->office_type === null || $row->office_type === '' || strtolower((string) $row->office_type) === 'student',
                'diagnosis' => [],
                'cases' => [],
            ],
            'faculty' => [
                'filter' => fn ($row) => strtolower((string) $row->office_type) === 'faculty',
                'diagnosis' => [],
                'cases' => [],
            ],
            'admin' => [
                'filter' => fn ($row) => strtolower((string) $row->office_type) === 'administrative',
                'diagnosis' => [],
                'cases' => [],
            ],
            'dependents' => [
                'filter' => fn ($row) => strtolower((string) $row->office_type) === 'dependent',
                'diagnosis' => [],
                'cases' => [],
            ],
        ];

        foreach ($groups as $groupKey => &$group) {
            $groupRows = $records->filter($group['filter'])->take(3)->values();

            for ($i = 0; $i < 3; $i++) {
                $row = $groupRows->get($i);
                $slot = $i + 1;

                $group['diagnosis'][$slot] = $row?->treatment_done ?? '—';
                $group['cases'][$slot] = $row ? (string) $row->total : '—';
            }
        }
        unset($group);

        return [
            'report_month' => strtoupper($currentMonth->format('F Y')),
            'clinic_name' => strtoupper($clinicName),
            'students_diagnosis_1' => $groups['students']['diagnosis'][1],
            'students_diagnosis_2' => $groups['students']['diagnosis'][2],
            'students_diagnosis_3' => $groups['students']['diagnosis'][3],
            'students_cases_1' => $groups['students']['cases'][1],
            'students_cases_2' => $groups['students']['cases'][2],
            'students_cases_3' => $groups['students']['cases'][3],
            'faculty_diagnosis_1' => $groups['faculty']['diagnosis'][1],
            'faculty_diagnosis_2' => $groups['faculty']['diagnosis'][2],
            'faculty_diagnosis_3' => $groups['faculty']['diagnosis'][3],
            'faculty_cases_1' => $groups['faculty']['cases'][1],
            'faculty_cases_2' => $groups['faculty']['cases'][2],
            'faculty_cases_3' => $groups['faculty']['cases'][3],
            'admin_diagnosis_1' => $groups['admin']['diagnosis'][1],
            'admin_diagnosis_2' => $groups['admin']['diagnosis'][2],
            'admin_diagnosis_3' => $groups['admin']['diagnosis'][3],
            'admin_cases_1' => $groups['admin']['cases'][1],
            'admin_cases_2' => $groups['admin']['cases'][2],
            'admin_cases_3' => $groups['admin']['cases'][3],
            'dependents_diagnosis_1' => $groups['dependents']['diagnosis'][1],
            'dependents_diagnosis_2' => $groups['dependents']['diagnosis'][2],
            'dependents_diagnosis_3' => $groups['dependents']['diagnosis'][3],
            'dependents_cases_1' => $groups['dependents']['cases'][1],
            'dependents_cases_2' => $groups['dependents']['cases'][2],
            'dependents_cases_3' => $groups['dependents']['cases'][3],
        ];
    }

    private function buildGadReportContext(): array
    {
        $currentMonth = now();
        $monthYear = strtoupper($currentMonth->format('F Y'));
        $campusName = strtoupper(setting('clinic_name', 'Taguig Dental Clinic'));

        $records = DailyTreatmentRecord::query()
            ->whereYear('treatment_date', $currentMonth->year)
            ->whereMonth('treatment_date', $currentMonth->month)
            ->select('office_type', 'gender', 'treatment_done', DB::raw('COUNT(*) as total'))
            ->groupBy('office_type', 'gender', 'treatment_done')
            ->get();

        $officeTypes = [
            'students' => null,
            'faculty' => 'Faculty',
            'administrative' => 'Administrative',
            'dependent' => 'Dependent',
        ];

        $headers = [];
        foreach ($officeTypes as $key => $label) {
            $headers[$key] = (int) $records->where('office_type', $label)->sum('total');
        }

        $categoryRows = $records
            ->groupBy('treatment_done')
            ->map(fn ($group, $name) => [
                'name' => $name,
                'total' => (int) $group->sum('total'),
            ])
            ->sortByDesc('total')
            ->take(3)
            ->values();

        $officeCategoryTotals = [];
        foreach (['students', 'faculty', 'administrative', 'dependent'] as $officeKey) {
            $officeCategoryTotals[$officeKey] = [];
            for ($i = 0; $i < 3; $i++) {
                $officeCategoryTotals[$officeKey][$i] = [
                    'male' => 0,
                    'female' => 0,
                    'total' => 0,
                ];
            }
        }

        foreach ($categoryRows as $index => $category) {
            $treatmentName = $category['name'];
            $rowsForTreatment = $records->where('treatment_done', $treatmentName);

            foreach (['students' => null, 'faculty' => 'Faculty', 'administrative' => 'Administrative', 'dependent' => 'Dependent'] as $officeKey => $officeLabel) {
                $officeRows = $rowsForTreatment->where('office_type', $officeLabel);
                $male = (int) $officeRows->where('gender', 'Male')->sum('total');
                $female = (int) $officeRows->where('gender', 'Female')->sum('total');

                $officeCategoryTotals[$officeKey][$index] = [
                    'male' => $male,
                    'female' => $female,
                    'total' => $male + $female,
                ];
            }
        }

        $maleTotals = [
            (int) $records->where('office_type', null)->where('gender', 'Male')->sum('total'),
            (int) $records->where('office_type', 'Faculty')->where('gender', 'Male')->sum('total'),
            (int) $records->where('office_type', 'Administrative')->where('gender', 'Male')->sum('total'),
            (int) $records->where('office_type', 'Dependent')->where('gender', 'Male')->sum('total'),
        ];

        $femaleTotals = [
            (int) $records->where('office_type', null)->where('gender', 'Female')->sum('total'),
            (int) $records->where('office_type', 'Faculty')->where('gender', 'Female')->sum('total'),
            (int) $records->where('office_type', 'Administrative')->where('gender', 'Female')->sum('total'),
            (int) $records->where('office_type', 'Dependent')->where('gender', 'Female')->sum('total'),
        ];

        $totalStudents = $maleTotals[0] + $femaleTotals[0];
        $totalFaculty = $maleTotals[1] + $femaleTotals[1];
        $totalAdministrative = $maleTotals[2] + $femaleTotals[2];
        $totalDependent = $maleTotals[3] + $femaleTotals[3];

        $grandTotal = $totalStudents + $totalFaculty + $totalAdministrative + $totalDependent;

        return [
            'pup_logo' => asset('images/PUP.png'),
            'bagong_pilipinas_logo' => asset('images/bagong-pilipinas.png'),
            'iso_logo' => asset('images/iso9001.png'),
            'iab_logo' => asset('images/iso9001.png'),
            'report_month_year' => $monthYear,
            'campus_name' => $campusName,
            'header_students' => (string) $headers['students'],
            'header_faculty' => (string) $headers['faculty'],
            'header_administrative' => (string) $headers['administrative'],
            'header_dependent' => (string) $headers['dependent'],
            'header_total' => (string) $grandTotal,
            'gad_category_1' => $categoryRows[0]['name'] ?? '—',
            'gad_category_2' => $categoryRows[1]['name'] ?? '—',
            'gad_category_3' => $categoryRows[2]['name'] ?? '—',
            'cat1_male_students' => (string) ($officeCategoryTotals['students'][0]['male'] ?? 0),
            'cat1_male_faculty' => (string) ($officeCategoryTotals['faculty'][0]['male'] ?? 0),
            'cat1_male_administrative' => (string) ($officeCategoryTotals['administrative'][0]['male'] ?? 0),
            'cat1_male_dependent' => (string) ($officeCategoryTotals['dependent'][0]['male'] ?? 0),
            'cat1_male_total' => (string) array_sum([
                $officeCategoryTotals['students'][0]['male'] ?? 0,
                $officeCategoryTotals['faculty'][0]['male'] ?? 0,
                $officeCategoryTotals['administrative'][0]['male'] ?? 0,
                $officeCategoryTotals['dependent'][0]['male'] ?? 0,
            ]),
            'cat1_female_students' => (string) ($officeCategoryTotals['students'][0]['female'] ?? 0),
            'cat1_female_faculty' => (string) ($officeCategoryTotals['faculty'][0]['female'] ?? 0),
            'cat1_female_administrative' => (string) ($officeCategoryTotals['administrative'][0]['female'] ?? 0),
            'cat1_female_dependent' => (string) ($officeCategoryTotals['dependent'][0]['female'] ?? 0),
            'cat1_female_total' => (string) array_sum([
                $officeCategoryTotals['students'][0]['female'] ?? 0,
                $officeCategoryTotals['faculty'][0]['female'] ?? 0,
                $officeCategoryTotals['administrative'][0]['female'] ?? 0,
                $officeCategoryTotals['dependent'][0]['female'] ?? 0,
            ]),
            'cat2_male_students' => (string) ($officeCategoryTotals['students'][1]['male'] ?? 0),
            'cat2_male_faculty' => (string) ($officeCategoryTotals['faculty'][1]['male'] ?? 0),
            'cat2_male_administrative' => (string) ($officeCategoryTotals['administrative'][1]['male'] ?? 0),
            'cat2_male_dependent' => (string) ($officeCategoryTotals['dependent'][1]['male'] ?? 0),
            'cat2_male_total' => (string) array_sum([
                $officeCategoryTotals['students'][1]['male'] ?? 0,
                $officeCategoryTotals['faculty'][1]['male'] ?? 0,
                $officeCategoryTotals['administrative'][1]['male'] ?? 0,
                $officeCategoryTotals['dependent'][1]['male'] ?? 0,
            ]),
            'cat2_female_students' => (string) ($officeCategoryTotals['students'][1]['female'] ?? 0),
            'cat2_female_faculty' => (string) ($officeCategoryTotals['faculty'][1]['female'] ?? 0),
            'cat2_female_administrative' => (string) ($officeCategoryTotals['administrative'][1]['female'] ?? 0),
            'cat2_female_dependent' => (string) ($officeCategoryTotals['dependent'][1]['female'] ?? 0),
            'cat2_female_total' => (string) array_sum([
                $officeCategoryTotals['students'][1]['female'] ?? 0,
                $officeCategoryTotals['faculty'][1]['female'] ?? 0,
                $officeCategoryTotals['administrative'][1]['female'] ?? 0,
                $officeCategoryTotals['dependent'][1]['female'] ?? 0,
            ]),
            'cat3_male_students' => (string) ($officeCategoryTotals['students'][2]['male'] ?? 0),
            'cat3_male_faculty' => (string) ($officeCategoryTotals['faculty'][2]['male'] ?? 0),
            'cat3_male_administrative' => (string) ($officeCategoryTotals['administrative'][2]['male'] ?? 0),
            'cat3_male_dependent' => (string) ($officeCategoryTotals['dependent'][2]['male'] ?? 0),
            'cat3_male_total' => (string) array_sum([
                $officeCategoryTotals['students'][2]['male'] ?? 0,
                $officeCategoryTotals['faculty'][2]['male'] ?? 0,
                $officeCategoryTotals['administrative'][2]['male'] ?? 0,
                $officeCategoryTotals['dependent'][2]['male'] ?? 0,
            ]),
            'cat3_female_students' => (string) ($officeCategoryTotals['students'][2]['female'] ?? 0),
            'cat3_female_faculty' => (string) ($officeCategoryTotals['faculty'][2]['female'] ?? 0),
            'cat3_female_administrative' => (string) ($officeCategoryTotals['administrative'][2]['female'] ?? 0),
            'cat3_female_dependent' => (string) ($officeCategoryTotals['dependent'][2]['female'] ?? 0),
            'cat3_female_total' => (string) array_sum([
                $officeCategoryTotals['students'][2]['female'] ?? 0,
                $officeCategoryTotals['faculty'][2]['female'] ?? 0,
                $officeCategoryTotals['administrative'][2]['female'] ?? 0,
                $officeCategoryTotals['dependent'][2]['female'] ?? 0,
            ]),
            'total_students' => (string) $totalStudents,
            'total_faculty' => (string) $totalFaculty,
            'total_administrative' => (string) $totalAdministrative,
            'total_dependent' => (string) $totalDependent,
            'grand_total' => (string) $grandTotal,
            'prepared_by_signature' => asset('images/sir.lim-sign.png'),
            'prepared_by' => 'Ronilo I. Lim',
            'prepared_by_role' => 'Dental Aide',
            'submitted_by_signature' => asset('images/dr.angeles-sign.png'),
            'submitted_by' => 'Nelson P. Angeles, DMD',
            'submitted_by_role' => 'Dentist II',
        ];
    }

    private function buildDentalSuppliesInventoryContext(): array
    {
        $currentMonth = now();
        $clinicName = setting('clinic_name', 'Taguig Dental Clinic');

        $records = Inventory::query()
            ->whereYear('date_received', $currentMonth->year)
            ->whereMonth('date_received', $currentMonth->month)
            ->orderByDesc('date_received')
            ->orderByDesc('id')
            ->take(35)
            ->get()
            ->values();

        $context = [
            'pup_logo' => asset('images/PUP.png'),
            'bagong_pilipinas_logo' => asset('images/bagong-pilipinas.png'),
            'report_month_year' => strtoupper($currentMonth->format('F Y')),
            'clinic_name' => strtoupper($clinicName),
        ];

        for ($i = 1; $i <= 35; $i++) {
            $record = $records->get($i - 1);

            $context['date_received_' . $i] = $record?->formatted_date ?? '—';
            $context['stock_number_' . $i] = $record?->stock_no ?? '—';
            $context['supply_name_' . $i] = $record?->name ?? '—';
            $context['unit_' . $i] = $record?->unit ?? '—';
            $context['quantity_' . $i] = $record ? (string) $record->qty : '—';
            $context['consumed_' . $i] = $record ? (string) $record->used : '—';
            $context['balance_' . $i] = $record ? (string) ($record->qty - $record->used) : '—';
        }

        return $context;
    }

    private function buildMedicineInventoryContext(): array
    {
        $currentMonth = now();
        $clinicName = setting('clinic_name', 'Taguig Dental Clinic');

        $records = Inventory::query()
            ->where('category', 'Medicine')
            ->whereYear('date_received', $currentMonth->year)
            ->whereMonth('date_received', $currentMonth->month)
            ->orderByDesc('date_received')
            ->orderByDesc('id')
            ->take(35)
            ->get()
            ->values();

        $context = [
            'pup_logo' => asset('images/PUP.png'),
            'bagong_pilipinas_logo' => asset('images/bagong-pilipinas.png'),
            'report_month_year' => strtoupper($currentMonth->format('F Y')),
            'clinic_name' => strtoupper($clinicName),
        ];

        for ($i = 1; $i <= 35; $i++) {
            $record = $records->get($i - 1);

            $context['date_received_' . $i] = $record?->formatted_date ?? '—';
            $context['stock_number_' . $i] = $record?->stock_no ?? '—';
            $context['supply_name_' . $i] = $record?->name ?? '—';
            $context['unit_' . $i] = $record?->unit ?? '—';
            $context['quantity_' . $i] = $record ? (string) $record->qty : '—';
            $context['consumed_' . $i] = $record ? (string) $record->used : '—';
            $context['balance_' . $i] = $record ? (string) ($record->qty - $record->used) : '—';
        }

        return $context;
    }

    private function buildDailyTreatmentRecordContext(): array
    {
        $currentMonth = now();
        $clinicName = setting('clinic_name', 'Taguig Dental Clinic');

        $records = DailyTreatmentRecord::query()
            ->whereYear('treatment_date', $currentMonth->year)
            ->whereMonth('treatment_date', $currentMonth->month)
            ->orderByDesc('treatment_date')
            ->orderByDesc('id')
            ->take(12)
            ->get()
            ->values();

        $context = [
            'pup_logo' => asset('images/PUP.png'),
            'bagong_pilipinas_logo' => asset('images/bagong-pilipinas.png'),
            'report_month_year' => strtoupper($currentMonth->format('F Y')),
            'clinic_name' => strtoupper($clinicName),
            'prepared_by_signature' => asset('images/sir.lim-sign.png'),
            'prepared_by' => 'Ronilo I. Lim',
            'prepared_by_role' => 'Dental Aide',
            'noted_by_signature' => asset('images/dr.angeles-sign.png'),
            'noted_by' => 'Nelson P. Angeles, DMD',
            'noted_by_role' => 'Dentist',
        ];

        for ($i = 1; $i <= 12; $i++) {
            $record = $records->get($i - 1);

            $contact = trim(implode(' / ', array_filter([
                $record?->patient_email,
                $record?->patient_phone,
            ], fn ($value) => is_string($value) && trim($value) !== '')));

            $officeOrProgram = $record?->office_type ?: ($record?->program_code ?: '—');

            $context['row_' . $i . '_date'] = $record?->treatment_date?->format('m/d/y') ?? '—';
            $context['row_' . $i . '_patient_name'] = $record?->patient_name ?? '—';
            $context['row_' . $i . '_contact'] = $contact !== '' ? $contact : '—';
            $context['row_' . $i . '_office'] = $officeOrProgram;
            $context['row_' . $i . '_gender'] = $record?->gender ?? '—';
            $context['row_' . $i . '_treatment'] = $record?->treatment_done ?? '—';
            $context['row_' . $i . '_processed'] = $record?->updated_at?->format('m/d/y g:i A') ?? '—';
            $context['row_' . $i . '_minutes'] = $record ? (string) $record->minutes_processed : '—';
            $context['row_' . $i . '_signature'] = $record?->has_signature ? '✓' : '—';
        }

        return $context;
    }

    private function buildDentalServicesContext(): array
    {
        $currentMonth = now();

        $records = DentalServiceRecord::query()
            ->whereYear('time_in', $currentMonth->year)
            ->whereMonth('time_in', $currentMonth->month)
            ->orderByDesc('time_in')
            ->orderByDesc('id')
            ->take(15)
            ->get()
            ->values();

        $context = [
            'pup_logo' => asset('images/PUP.png'),
            'bagong_pilipinas_logo' => asset('images/bagong-pilipinas.png'),
            'form_code' => 'PUP-TDR-F-MEDS-002',
            'revision_no' => '0',
            'revision_date' => 'April 11, 2025',
        ];

        for ($i = 1; $i <= 15; $i++) {
            $record = $records->get($i - 1);

            $middleInitial = '';
            if ($record?->patient_middle_name && trim((string) $record->patient_middle_name) !== '') {
                $middleInitial = strtoupper(substr((string) $record->patient_middle_name, 0, 1)) . '.';
            }

            $name = $record
                ? trim(($record->patient_last_name ?? '') . ', ' . ($record->patient_first_name ?? '') . ' ' . $middleInitial)
                : '—';

            $courseSectionDepartment = '—';
            if ($record) {
                if (($record->department ?? '') === 'Student') {
                    $courseSectionDepartment = trim(implode(' ', array_filter([
                        $record->program_code,
                        $record->year_level,
                        $record->section ? '-' . $record->section : null,
                    ], fn ($value) => $value !== null && $value !== '')));
                } else {
                    $courseSectionDepartment = (string) ($record->department ?? '—');
                }

                if ($courseSectionDepartment === '') {
                    $courseSectionDepartment = '—';
                }
            }

            $processingTime = '—';
            if ($record?->time_in && $record?->time_out) {
                $processingTime = (string) $record->time_in->diffInMinutes($record->time_out);
            }

            $context['date_' . $i] = $record?->time_in?->format('m/d/y') ?? '—';
            $context['time_in_' . $i] = $record?->time_in?->format('h:i A') ?? '—';
            $context['patient_name_' . $i] = $name;
            $context['course_section_department_' . $i] = $courseSectionDepartment;
            $context['age_' . $i] = $record?->age !== null ? (string) $record->age : '—';
            $context['male_' . $i] = ($record?->gender === 'Male') ? '✓' : '—';
            $context['female_' . $i] = ($record?->gender === 'Female') ? '✓' : '—';
            $context['senior_citizen_' . $i] = $record?->is_senior ? '✓' : '—';
            $context['pwd_' . $i] = $record?->is_pwd ? '✓' : '—';
            $context['email_address_' . $i] = $record?->email ?? '—';
            $context['contact_number_' . $i] = $record?->contact ?? '—';
            $context['time_processed_' . $i] = $record?->time_out?->format('h:i A') ?? '—';
            $context['processing_time_' . $i] = $processingTime;
            $context['emergency_case_' . $i] = ($record?->visit_type === 'Emergency') ? '✓' : '—';
            $context['non_emergency_case_' . $i] = ($record?->visit_type === 'Non-Emergency') ? '✓' : '—';
            $context['signature_' . $i] = $record?->has_signature ? '✓' : '—';
        }

        return $context;
    }

    private function resolveValue(string $fieldKey, ?DocumentTemplateField $field, array $context): mixed
    {
        if (array_key_exists($fieldKey, $context) && $context[$fieldKey] !== null && $context[$fieldKey] !== '') {
            return $context[$fieldKey];
        }

        return match ($fieldKey) {
            'date' => now()->format('F d, Y'),
            'student_name' => $this->extractName($context, ['student', 'patient', 'user'])
                ?? $field?->sample_value,
            'examination_date' => $this->extractDate($context, ['appointment', 'exam_date'])
                ?? $field?->sample_value,
            'lic_no' => $context['lic_no']
                ?? setting('dentist_license_no', $field?->sample_value ?? 'PRC No. __________'),
            default => $field?->sample_value ?? '—',
        };
    }

    private function extractName(array $context, array $keys): ?string
    {
        foreach ($keys as $key) {
            $value = data_get($context, $key . '.name');

            if (is_string($value) && trim($value) !== '') {
                return $value;
            }

            $value = data_get($context, $key);

            if (is_string($value) && trim($value) !== '') {
                return $value;
            }
        }

        return null;
    }

    private function extractDate(array $context, array $keys): ?string
    {
        foreach ($keys as $key) {
            $value = data_get($context, $key . '.appointment_date')
                ?? data_get($context, $key . '.date')
                ?? data_get($context, $key);

            if ($value === null || $value === '') {
                continue;
            }

            if ($value instanceof Carbon) {
                return $value->format('F d, Y');
            }

            try {
                return Carbon::parse((string) $value)->format('F d, Y');
            } catch (\Throwable) {
                if (is_string($value) && trim($value) !== '') {
                    return $value;
                }
            }
        }

        return null;
    }
}