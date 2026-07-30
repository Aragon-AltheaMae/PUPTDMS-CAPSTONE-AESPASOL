<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentTemplateField extends Model
{
    protected $fillable = [
        'document_type',
        'field_key',
        'label',
        'sample_value',
        'source_table',
        'source_column',
        'description',
    ];
}