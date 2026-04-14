<?php

namespace Database\Seeders;

use App\Models\DocumentTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DefaultDocumentTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Dental Certificate - Dental Clearance',
                'code' => 'DCLR-DEFAULT',
                'document_type' => 'dental_clearance',
                'category' => 'Clearance',
                'file_path' => resource_path('views/admin/document-templates-defaults/dental-clearance.blade.php'),
                'paper_size' => 'Letter',
                'orientation' => 'portrait',
                'notes' => 'Default template imported from dental_clearance.blade.php',
            ],
            [
                'name' => 'Dental Certificate - Annual Dental Clearance',
                'code' => 'ADCL-DEFAULT',
                'document_type' => 'annual_dental_clearance',
                'category' => 'Clearance',
                'file_path' => resource_path('views/admin/document-templates-defaults/annual-dental-clearance.blade.php'),
                'paper_size' => 'Letter',
                'orientation' => 'portrait',
                'notes' => 'Default template imported from annual_dental_clearance.blade.php',
            ],
            [
                'name' => 'Dental Cases',
                'code' => 'DCASE-DEFAULT',
                'document_type' => 'dental_cases',
                'category' => 'Report',
                'file_path' => resource_path('views/admin/document-templates-defaults/dental-cases.blade.php'),
                'paper_size' => 'Legal',
                'orientation' => 'portrait',
                'notes' => 'Default template imported from dental-cases.blade.php',
            ],
            [
                'name' => 'GAD Accomplishment Report',
                'code' => 'GADR-DEFAULT',
                'document_type' => 'gad_report',
                'category' => 'Report',
                'file_path' => resource_path('views/admin/document-templates-defaults/gad-report.blade.php'),
                'paper_size' => 'A4',
                'orientation' => 'portrait',
                'notes' => 'Default template imported from gad-report.blade.php',
            ],
            [
                'name' => 'Dental Supplies Inventory',
                'code' => 'DINV-DEFAULT',
                'document_type' => 'dental_supplies_inventory',
                'category' => 'Inventory',
                'file_path' => resource_path('views/admin/document-templates-defaults/dental-supplies-inventory.blade.php'),
                'paper_size' => 'Legal',
                'orientation' => 'portrait',
                'notes' => 'Default template imported from dental-supplies-inventory.blade.php',
            ],
            [
                'name' => 'Medicine Inventory',
                'code' => 'MINV-DEFAULT',
                'document_type' => 'medicine_inventory',
                'category' => 'Inventory',
                'file_path' => resource_path('views/admin/document-templates-defaults/medicine-inventory.blade.php'),
                'paper_size' => 'Legal',
                'orientation' => 'portrait',
                'notes' => 'Default template imported from medicine-inventory.blade.php',
            ],
            [
                'name' => 'Daily Treatment Record',
                'code' => 'DTR-DEFAULT',
                'document_type' => 'daily_treatment_record',
                'category' => 'Record',
                'file_path' => resource_path('views/admin/document-templates-defaults/daily-treatment.blade.php'),
                'paper_size' => 'Legal',
                'orientation' => 'landscape',
                'notes' => 'Default template imported from daily-treatment.blade.php',
            ],
            [
                'name' => 'Dental Services Record',
                'code' => 'DSRV-DEFAULT',
                'document_type' => 'dental_services',
                'category' => 'Record',
                'file_path' => resource_path('views/admin/document-templates-defaults/dental-services.blade.php'),
                'paper_size' => 'A4',
                'orientation' => 'landscape',
                'notes' => 'Default template imported from dental-services.blade.php',
            ],
        ];

        foreach ($templates as $template) {
            if (!File::exists($template['file_path'])) {
                $this->command?->warn("Template file not found: {$template['file_path']}");
                continue;
            }

            $content = File::get($template['file_path']);

            DocumentTemplate::updateOrCreate(
                ['code' => $template['code']],
                [
                    'name' => $template['name'],
                    'document_type' => $template['document_type'],
                    'category' => $template['category'],
                    'engine' => 'html',
                    'output_format' => 'pdf',
                    'header_content' => null,
                    'content' => $content,
                    'footer_content' => null,
                    'paper_size' => $template['paper_size'],
                    'orientation' => $template['orientation'],
                    'status' => 'active',
                    'is_default' => true,
                    'version' => 1,
                    'notes' => $template['notes'],
                    'created_by' => null,
                    'updated_by' => null,
                ]
            );
        }
    }
}