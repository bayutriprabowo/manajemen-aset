<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionMonitoringLog extends Model
{
    use HasFactory;

    protected $table = 'transaction_monitoring_logs';

    protected $fillable = [
        'transaction_date',
        'monitoring_id',
        'item_id',
        'department_id',
        'description',
        'quantity',
        'cost',
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

    public function monitoringForm()
    {
        return $this->belongsTo(TransactionMonitoringForm::class, 'monitoring_id');
    }
}
