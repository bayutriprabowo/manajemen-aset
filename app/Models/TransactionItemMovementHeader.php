<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItemMovementHeader extends Model
{
    use HasFactory;

    protected $table = 'transaction_item_movement_headers';

    protected $fillable = [
        'code',
        'user_id',
        'department_id_from',
        'department_id_to',
        'transaction_date',
        'status',
        'purpose',
        'status_id',
        'description',
    ];

    public function itemMovementDetail()
    {
        return $this->hasMany(TransactionItemMovementDetail::class, 'header_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function masterDepartmentFrom()
    {
        return $this->belongsTo(MasterDepartment::class, 'department_id_from');
    }

    public function masterDepartmentTo()
    {
        return $this->belongsTo(MasterDepartment::class, 'department_id_to');
    }

    public function masterStatus()
    {
        return $this->belongsTo(MasterItemStatus::class, 'status_id');
    }
}
