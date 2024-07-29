<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterCompany extends Model
{
    use HasFactory;

    protected $table = 'master_companies';

    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'company_id');
    }
}
