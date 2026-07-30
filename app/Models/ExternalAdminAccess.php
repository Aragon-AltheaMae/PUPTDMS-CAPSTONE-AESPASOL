<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalAdminAccess extends Model
{
    protected $table = 'external_admin_accesses';

    protected $fillable = [
        'external_admin_id',
        'fname',
        'lname',
        'email',
        'office',
        'address',
        'age',
        'gender',
        'contact_number',
        'senior_pwd',
        'has_cms_access',
        'cms_role',
        'cms_status',
    ];
}