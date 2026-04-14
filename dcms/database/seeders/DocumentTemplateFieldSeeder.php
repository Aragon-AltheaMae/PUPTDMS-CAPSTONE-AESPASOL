<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentTemplateField;

class DocumentTemplateFieldSeeder extends Seeder
{
    public function run(): void
    {
        $fields = [
            [
                'document_type' => 'dental_clearance',
                'field_key' => 'date',
                'label' => 'Document Date',
                'sample_value' => 'October 30, 2025',
                'source_table' => null,
                'source_column' => null,
                'description' => 'Date issued on the certificate',
            ],
            [
                'document_type' => 'dental_clearance',
                'field_key' => 'student_name',
                'label' => 'Student Name',
                'sample_value' => 'Juan Dela Cruz',
                'source_table' => 'patients',
                'source_column' => 'name',
                'description' => 'Full patient name',
            ],
            [
                'document_type' => 'dental_clearance',
                'field_key' => 'examination_date',
                'label' => 'Examination Date',
                'sample_value' => 'October 30, 2025',
                'source_table' => 'appointments',
                'source_column' => 'appointment_date',
                'description' => 'Date patient was examined',
            ],
            [
                'document_type' => 'dental_clearance',
                'field_key' => 'lic_no',
                'label' => 'License Number',
                'sample_value' => 'PRC No. 123456',
                'source_table' => null,
                'source_column' => null,
                'description' => 'Dentist license number from clinic settings',
            ],
            [
                'document_type' => 'annual_dental_clearance',
                'field_key' => 'date',
                'label' => 'Document Date',
                'sample_value' => 'October 30, 2025',
                'source_table' => null,
                'source_column' => null,
                'description' => 'Date issued on the certificate',
            ],
            [
                'document_type' => 'annual_dental_clearance',
                'field_key' => 'student_name',
                'label' => 'Student Name',
                'sample_value' => 'Juan Dela Cruz',
                'source_table' => 'patients',
                'source_column' => 'name',
                'description' => 'Full patient name',
            ],
            [
                'document_type' => 'annual_dental_clearance',
                'field_key' => 'examination_date',
                'label' => 'Examination Date',
                'sample_value' => 'October 30, 2025',
                'source_table' => 'appointments',
                'source_column' => 'appointment_date',
                'description' => 'Date patient was examined',
            ],
            [
                'document_type' => 'annual_dental_clearance',
                'field_key' => 'lic_no',
                'label' => 'License Number',
                'sample_value' => 'PRC No. 123456',
                'source_table' => null,
                'source_column' => null,
                'description' => 'Dentist license number from clinic settings',
            ],
            [
                'document_type' => 'daily_treatment_record',
                'field_key' => 'report_date',
                'label' => 'Report Date',
                'sample_value' => 'October 30, 2025',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_date',
                'description' => 'Date of report',
            ],
            [
                'document_type' => 'daily_treatment_record',
                'field_key' => 'report_month_year',
                'label' => 'Report Month and Year',
                'sample_value' => 'APRIL 2026',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_date',
                'description' => 'Month and year covered by the report',
            ],
            [
                'document_type' => 'daily_treatment_record',
                'field_key' => 'clinic_name',
                'label' => 'Clinic Name',
                'sample_value' => 'TAGUIG DENTAL CLINIC',
                'source_table' => 'system_settings',
                'source_column' => 'clinic_name',
                'description' => 'Clinic name for the report header',
            ],
            [
                'document_type' => 'daily_treatment_record',
                'field_key' => 'prepared_by',
                'label' => 'Prepared By',
                'sample_value' => 'Ronilo I. Lim',
                'source_table' => null,
                'source_column' => null,
                'description' => 'Prepared by signatory',
            ],
            [
                'document_type' => 'daily_treatment_record',
                'field_key' => 'noted_by',
                'label' => 'Noted By',
                'sample_value' => 'Dr. Nelson P. Angeles',
                'source_table' => null,
                'source_column' => null,
                'description' => 'Noted by signatory',
            ],
            [
                'document_type' => 'daily_treatment_record',
                'field_key' => 'prepared_by_role',
                'label' => 'Prepared By Role',
                'sample_value' => 'Dental Aide',
                'source_table' => null,
                'source_column' => null,
                'description' => 'Title under prepared by signatory',
            ],
            [
                'document_type' => 'daily_treatment_record',
                'field_key' => 'noted_by_role',
                'label' => 'Noted By Role',
                'sample_value' => 'Dentist',
                'source_table' => null,
                'source_column' => null,
                'description' => 'Title under noted by signatory',
            ],
            [
                'document_type' => 'daily_treatment_record',
                'field_key' => 'prepared_by_signature',
                'label' => 'Prepared By Signature',
                'sample_value' => 'signature',
                'source_table' => null,
                'source_column' => null,
                'description' => 'Signature image for prepared by',
            ],
            [
                'document_type' => 'daily_treatment_record',
                'field_key' => 'noted_by_signature',
                'label' => 'Noted By Signature',
                'sample_value' => 'signature',
                'source_table' => null,
                'source_column' => null,
                'description' => 'Signature image for noted by',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'report_month',
                'label' => 'Report Month',
                'sample_value' => 'JANUARY 2026',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_date',
                'description' => 'Month the cases report covers',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'clinic_name',
                'label' => 'Clinic Name',
                'sample_value' => 'TAGUIG DENTAL CLINIC',
                'source_table' => 'system_settings',
                'source_column' => 'clinic_name',
                'description' => 'Clinic name from system settings',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'students_diagnosis_1',
                'label' => 'Students Diagnosis 1',
                'sample_value' => 'Dental Caries',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Top diagnosis for students',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'students_cases_1',
                'label' => 'Students Cases 1',
                'sample_value' => '52',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Count for top students diagnosis',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'students_diagnosis_2',
                'label' => 'Students Diagnosis 2',
                'sample_value' => 'Gingivitis',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Second diagnosis for students',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'students_cases_2',
                'label' => 'Students Cases 2',
                'sample_value' => '10',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Count for second students diagnosis',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'students_diagnosis_3',
                'label' => 'Students Diagnosis 3',
                'sample_value' => 'Periapical Abscess',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Third diagnosis for students',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'students_cases_3',
                'label' => 'Students Cases 3',
                'sample_value' => '6',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Count for third students diagnosis',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'faculty_diagnosis_1',
                'label' => 'Faculty Diagnosis 1',
                'sample_value' => 'Gingivitis',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Top diagnosis for faculty',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'faculty_cases_1',
                'label' => 'Faculty Cases 1',
                'sample_value' => '1',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Count for faculty diagnosis',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'faculty_diagnosis_2',
                'label' => 'Faculty Diagnosis 2',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Second diagnosis for faculty',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'faculty_cases_2',
                'label' => 'Faculty Cases 2',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Count for second faculty diagnosis',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'faculty_diagnosis_3',
                'label' => 'Faculty Diagnosis 3',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Third diagnosis for faculty',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'faculty_cases_3',
                'label' => 'Faculty Cases 3',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Count for third faculty diagnosis',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'admin_diagnosis_1',
                'label' => 'Administrative Diagnosis 1',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Top diagnosis for administrative personnel',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'admin_cases_1',
                'label' => 'Administrative Cases 1',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Count for administrative diagnosis',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'admin_diagnosis_2',
                'label' => 'Administrative Diagnosis 2',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Second diagnosis for administrative personnel',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'admin_cases_2',
                'label' => 'Administrative Cases 2',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Count for second administrative diagnosis',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'admin_diagnosis_3',
                'label' => 'Administrative Diagnosis 3',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Third diagnosis for administrative personnel',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'admin_cases_3',
                'label' => 'Administrative Cases 3',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Count for third administrative diagnosis',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'dependents_diagnosis_1',
                'label' => 'Dependents Diagnosis 1',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Top diagnosis for dependents and alumni',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'dependents_cases_1',
                'label' => 'Dependents Cases 1',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Count for dependent diagnosis',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'dependents_diagnosis_2',
                'label' => 'Dependents Diagnosis 2',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Second diagnosis for dependents and alumni',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'dependents_cases_2',
                'label' => 'Dependents Cases 2',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Count for second dependent diagnosis',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'dependents_diagnosis_3',
                'label' => 'Dependents Diagnosis 3',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Third diagnosis for dependents and alumni',
            ],
            [
                'document_type' => 'dental_cases',
                'field_key' => 'dependents_cases_3',
                'label' => 'Dependents Cases 3',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Count for third dependent diagnosis',
            ],
        ];

        $fields = array_merge($fields, $this->buildDailyTreatmentRecordFields());
        $fields = array_merge($fields, $this->buildDentalSuppliesInventoryFields());

        foreach ($fields as $field) {
            DocumentTemplateField::updateOrCreate(
                [
                    'document_type' => $field['document_type'],
                    'field_key' => $field['field_key'],
                ],
                $field
            );
        }
    }

    private function buildDailyTreatmentRecordFields(): array
    {
        $fields = [];

        for ($i = 1; $i <= 12; $i++) {
            $fields[] = [
                'document_type' => 'daily_treatment_record',
                'field_key' => 'row_' . $i . '_date',
                'label' => 'Row ' . $i . ' Date',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_date',
                'description' => 'Date / time requested for row ' . $i,
            ];

            $fields[] = [
                'document_type' => 'daily_treatment_record',
                'field_key' => 'row_' . $i . '_patient_name',
                'label' => 'Row ' . $i . ' Patient Name',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'patient_name',
                'description' => 'Patient name for row ' . $i,
            ];

            $fields[] = [
                'document_type' => 'daily_treatment_record',
                'field_key' => 'row_' . $i . '_contact',
                'label' => 'Row ' . $i . ' Contact',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'patient_email',
                'description' => 'Email/contact number for row ' . $i,
            ];

            $fields[] = [
                'document_type' => 'daily_treatment_record',
                'field_key' => 'row_' . $i . '_office',
                'label' => 'Row ' . $i . ' Office',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'office_type',
                'description' => 'Office or program for row ' . $i,
            ];

            $fields[] = [
                'document_type' => 'daily_treatment_record',
                'field_key' => 'row_' . $i . '_gender',
                'label' => 'Row ' . $i . ' Gender',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'gender',
                'description' => 'Gender for row ' . $i,
            ];

            $fields[] = [
                'document_type' => 'daily_treatment_record',
                'field_key' => 'row_' . $i . '_treatment',
                'label' => 'Row ' . $i . ' Treatment',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'treatment_done',
                'description' => 'Treatment done for row ' . $i,
            ];

            $fields[] = [
                'document_type' => 'daily_treatment_record',
                'field_key' => 'row_' . $i . '_processed',
                'label' => 'Row ' . $i . ' Processed',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'updated_at',
                'description' => 'Date / time processed for row ' . $i,
            ];

            $fields[] = [
                'document_type' => 'daily_treatment_record',
                'field_key' => 'row_' . $i . '_minutes',
                'label' => 'Row ' . $i . ' Minutes',
                'sample_value' => '0',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'minutes_processed',
                'description' => 'Minutes processed for row ' . $i,
            ];

            $fields[] = [
                'document_type' => 'daily_treatment_record',
                'field_key' => 'row_' . $i . '_signature',
                'label' => 'Row ' . $i . ' Signature',
                'sample_value' => '—',
                'source_table' => 'daily_treatment_records',
                'source_column' => 'has_signature',
                'description' => 'Patient signature marker for row ' . $i,
            ];
        }

        return $fields;
    }

    private function buildDentalSuppliesInventoryFields(): array
    {
        $fields = [
            [
                'document_type' => 'dental_supplies_inventory',
                'field_key' => 'report_month_year',
                'label' => 'Report Month and Year',
                'sample_value' => 'JANUARY 2026',
                'source_table' => 'inventory_items',
                'source_column' => 'date_received',
                'description' => 'Month and year covered by the inventory report',
            ],
            [
                'document_type' => 'dental_supplies_inventory',
                'field_key' => 'clinic_name',
                'label' => 'Clinic Name',
                'sample_value' => 'TAGUIG DENTAL CLINIC',
                'source_table' => 'system_settings',
                'source_column' => 'clinic_name',
                'description' => 'Clinic name from system settings',
            ],
        ];

        for ($i = 1; $i <= 35; $i++) {
            $fields[] = [
                'document_type' => 'dental_supplies_inventory',
                'field_key' => 'date_received_' . $i,
                'label' => 'Date Received ' . $i,
                'sample_value' => '—',
                'source_table' => 'inventory_items',
                'source_column' => 'date_received',
                'description' => 'Date the supply item was received for row ' . $i,
            ];

            $fields[] = [
                'document_type' => 'dental_supplies_inventory',
                'field_key' => 'stock_number_' . $i,
                'label' => 'Stock Number ' . $i,
                'sample_value' => '—',
                'source_table' => 'inventory_items',
                'source_column' => 'stock_no',
                'description' => 'Stock number for row ' . $i,
            ];

            $fields[] = [
                'document_type' => 'dental_supplies_inventory',
                'field_key' => 'supply_name_' . $i,
                'label' => 'Supply Name ' . $i,
                'sample_value' => '—',
                'source_table' => 'inventory_items',
                'source_column' => 'name',
                'description' => 'Supply name for row ' . $i,
            ];

            $fields[] = [
                'document_type' => 'dental_supplies_inventory',
                'field_key' => 'unit_' . $i,
                'label' => 'Unit ' . $i,
                'sample_value' => '—',
                'source_table' => 'inventory_items',
                'source_column' => 'unit',
                'description' => 'Unit of measure for row ' . $i,
            ];

            $fields[] = [
                'document_type' => 'dental_supplies_inventory',
                'field_key' => 'quantity_' . $i,
                'label' => 'Quantity ' . $i,
                'sample_value' => '—',
                'source_table' => 'inventory_items',
                'source_column' => 'qty',
                'description' => 'Quantity received for row ' . $i,
            ];

            $fields[] = [
                'document_type' => 'dental_supplies_inventory',
                'field_key' => 'consumed_' . $i,
                'label' => 'Consumed ' . $i,
                'sample_value' => '—',
                'source_table' => 'inventory_items',
                'source_column' => 'used',
                'description' => 'Quantity consumed for row ' . $i,
            ];

            $fields[] = [
                'document_type' => 'dental_supplies_inventory',
                'field_key' => 'balance_' . $i,
                'label' => 'Balance ' . $i,
                'sample_value' => '—',
                'source_table' => 'inventory_items',
                'source_column' => 'qty, used',
                'description' => 'Remaining balance for row ' . $i,
            ];
        }

        return $fields;
    }
}