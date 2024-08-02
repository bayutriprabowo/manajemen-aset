<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterSection extends Model
{
    use HasFactory;

    protected $table = 'master_sections';

    public function masterCompany(): BelongsTo
    {
        return $this->belongsTo(MasterCompany::class, 'company_id');
    }

    public function masterDepartment(): BelongsTo
    {
        return $this->belongsTo(MasterDepartment::class, 'department_id');
    }
}
