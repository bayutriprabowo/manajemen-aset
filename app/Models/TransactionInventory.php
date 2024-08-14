<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionInventory extends Model
{
    use HasFactory;

    protected $table = 'transaction_inventories';

    protected $fillable = [
        'item_id',
        'department_id',
        'quantity'
    ];

    public function masterItem()
    {
        return $this->belongsTo(MasterItem::class, 'item_id');
    }

    public function masterDepartment()
    {
        return $this->belongsTo(MasterDepartment::class, 'department_id');
    }
}
