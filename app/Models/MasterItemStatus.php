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
}
