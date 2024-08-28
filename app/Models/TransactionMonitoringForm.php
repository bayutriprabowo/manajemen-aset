<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionMonitoringForm extends Model
{
    use HasFactory;

    protected $table = 'transaction_monitoring_forms';

    protected $fillable = [
        'id',
        'transaction_date',
        'item_id',
        'department_id',
        'user_id',
        'code',
        'period',
        'description',
        'quantity',
        'cost',
        'status',
        'photo_proof',
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

    public function monitoringLog()
    {
        return $this->hasMany(TransactionMonitoringLog::class, 'monitoring_id');
    }
}
