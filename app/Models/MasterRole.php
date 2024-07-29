<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterRole extends Model
{
    use HasFactory;

    protected $table = 'master_roles';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
