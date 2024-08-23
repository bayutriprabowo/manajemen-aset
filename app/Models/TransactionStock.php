<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionStock extends Model
{
    use HasFactory;

    protected $table = 'transaction_stocks';

    protected $fillable = [
        'code',
        'item_id',
        'in',
        'out',
        'transaction_date',
        'department_id',
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
