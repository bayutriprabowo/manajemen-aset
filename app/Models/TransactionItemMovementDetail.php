<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItemMovementDetail extends Model
{
    use HasFactory;

    protected $table = 'transaction_item_movement_details';

    protected $fillable = [
        'item_id',
        'stock',
        'quantity',
        'header_id',
    ];

    public function itemMovementHeader()
    {
        return $this->belongsTo(TransactionItemMovementHeader::class, 'header_id');
    }

    public function masterItem()
    {
        return $this->belongsTo(MasterItem::class, 'item_id');
    }
}
