<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDepreciation extends Model
{
    use HasFactory;

    protected $table = 'transaction_depreciations';

    protected $fillable = [
        'procurement_date',
        'item_id',
        'department_id',
        'user_id',
        'price',
        'useful_life',
        'residual_value',
        'depreciation_value',
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
}
