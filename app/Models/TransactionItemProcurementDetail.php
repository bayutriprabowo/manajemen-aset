<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItemProcurementDetail extends Model
{
    use HasFactory;

    protected $table = 'transaction_item_procurement_details';

    protected $fillable = [
        'item_id',
        'quantity',
        'price',
        'subtotal',
        'header_id',
        'department_id',
    ];

    public function procurementHeader()
    {
        return $this->belongsTo(TransactionItemProcurementHeader::class, 'header_id');
    }

    public function masterItem()
    {
        return $this->belongsTo(MasterItem::class, 'item_id');
    }

    public function masterDepartment()
    {
        return $this->belongsTo(MasterDepartment::class, 'department_id');
    }
}
