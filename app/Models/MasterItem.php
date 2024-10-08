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
        'barcode',
        'name',
        'price',
        'type_id',
    ];

    public function masterItemType(): BelongsTo
    {
        return $this->belongsTo(MasterItemType::class, 'type_id');
    }

    public function masterVendorItem()
    {
        return $this->hasMany(MasterVendorItem::class, 'item_id');
    }

    public function procurementDetail()
    {
        return $this->hasMany(TransactionItemProcurementDetail::class, 'item_id');
    }

    public function inventory()
    {
        return $this->hasMany(TransactionInventory::class, 'item_id');
    }

    public function incomingItem()
    {
        return $this->hasMany(TransactionIncomingItem::class, 'item_id');
    }

    public function outgoingItem()
    {
        return $this->hasMany(TransactionOutgoingItem::class, 'item_id');
    }

    public function itemMovementDetail()
    {
        return $this->hasMany(TransactionItemMovementDetail::class, 'item_id');
    }

    public function monitoringForm()
    {
        return $this->hasMany(TransactionMonitoringForm::class, 'item_id');
    }

    public function monitoringLog()
    {
        return $this->hasMany(TransactionMonitoringLog::class, 'item_id');
    }

    public function depreciation()
    {
        return $this->hasMany(TransactionDepreciation::class, 'item_id');
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
