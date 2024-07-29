<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MasterCompany extends Model
{
    use HasFactory;

    protected $table = 'master_companies';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
