<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterVendorItem extends Model
{
    use HasFactory;

    protected $table = 'master_vendor_items';

    protected $fillable = [
        'vendor_id',
        'item_id',
    ];

    public function masterVendor()
    {
        return $this->belongsTo(MasterVendor::class, 'vendor_id');
    }

    public function masterItem()
    {
        return $this->belongsTo(MasterItem::class, 'item_id');
    }
}
