<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionIncomingItem extends Model
{
    use HasFactory;

    protected $table = 'transaction_incoming_items';

    protected $fillable = [
        'code',
        'item_id',
        'department_id',
        'user_id',
        'quantity',
        'transaction_date',
        'status_id',
        'description',
    ];

    public function masterItem()
    {
        return $this->belongsTo(MasterItem::class, 'item_id');
    }

    public function masterDepartment()
    {
        return $this->belongsTo(MasterDepartment::class, 'department_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function masterItemStatus()
    {
        return $this->belongsTo(MasterItemStatus::class, 'status_id');
    }
}
