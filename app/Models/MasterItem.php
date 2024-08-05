<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterItem extends Model
{
    use HasFactory;

    protected $table = 'master_items';

    protected $fillable = [
        'name',
        'price',
        'type_id',
    ];

    public function masterItemType(): BelongsTo
    {
        return $this->belongsTo(MasterItemType::class, 'type_id');
    }

    // public function masterCompany(): BelongsTo
    // {
    //     return $this->belongsTo(MasterCompany::class, 'company_id');
    // }

    // public function masterDepartment(): BelongsTo
    // {
    //     return $this->belongsTo(MasterDepartment::class, 'department_id');
    // }

    // public function masterSection(): BelongsTo
    // {
    //     return $this->belongsTo(MasterSection::class, 'section_id');
    // }
}
