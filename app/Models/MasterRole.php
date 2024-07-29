<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterRole extends Model
{
    use HasFactory;

    protected $table = 'master_roles';

    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
