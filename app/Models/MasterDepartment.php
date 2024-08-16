<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterDepartment extends Model
{
    use HasFactory;

    protected $table = 'master_departments';

    protected $fillable = [
        'name',
        'address',
        'department_number',
        'contact_person',
        'contact_person_number',
        'company_id'
    ];

    // public function masterSection(): HasMany
    // {
    //     return $this->hasMany(MasterSection::class, 'department_id');
    // }

    public function masterCompany(): BelongsTo
    {
        return $this->belongsTo(MasterCompany::class, 'company_id');
    }

    public function transactionItemProcurementDetail(): HasMany
    {
        return $this->hasMany(TransactionItemProcurementDetail::class, 'department_id');
    }

    public function inventory()
    {
        return $this->hasMany(TransactionInventory::class, 'department_id');
    }

    public function incomingItem()
    {
        return $this->hasMany(TransactionIncomingItem::class, 'department_id');
    }

    public function outgoingItem()
    {
        return $this->hasMany(TransactionOutgoingItem::class, 'department_id');
    }
}
