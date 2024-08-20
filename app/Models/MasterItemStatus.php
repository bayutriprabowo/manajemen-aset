<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterItemStatus extends Model
{
    use HasFactory;

    protected $table = 'master_item_statuses';

    protected $fillable = [
        'description'
    ];

    public function incomingItem()
    {
        return $this->hasMany(TransactionIncomingItem::class, 'status_id');
    }

    public function outgoingItem()
    {
        return $this->hasMany(TransactionOutgoingItem::class, 'status_id');
    }

    public function ItemMovementHeader()
    {
        return $this->hasMany(TransactionItemMovementHeader::class, 'status_id');
    }
}
