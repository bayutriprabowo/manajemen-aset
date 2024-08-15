<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransactionItemProcurementHeader extends Model
{
    use HasFactory;

    protected $table = 'transaction_item_procurement_headers';

    protected $fillable = [
        'transaction_date',
        'status',
        'code',
        'description',
        'total',
        'vendor_id',
        'user_id',
    ];

    public function procurementDetail()
    {
        return $this->hasMany(TransactionItemProcurementDetail::class, 'header_id');
    }

    public function masterVendor()
    {
        return $this->belongsTo(MasterVendor::class, 'vendor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
