<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterItemType extends Model
{
    use HasFactory;

    protected $table = 'master_item_types';

    protected $fillable = [
        'name'
    ];

    public function masterItem(): HasMany
    {
        return $this->hasMany(MasterItem::class, 'type_id');
    }
}
