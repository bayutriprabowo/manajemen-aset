<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterVendor extends Model
{
    use HasFactory;

    protected $table = 'master_vendors';

    protected $fillable = [
        'name',
        'address',
        'office_number',
        'owner',
        'owner_number',
    ];

    public function masterVendorItem()
    {
        return $this->hasMany(MasterVendorItem::class, 'vendor_id');
    }

    public function procurementHeader()
    {
        return $this->hasMany(TransactionItemProcurementHeader::class, 'vendor_id');
    }
}
