<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterItemType extends Model
{
    use HasFactory;

    protected $table = 'master_item_types';

    protected $fillable = [
        'name'
    ];
}
