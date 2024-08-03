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

    protected $fillable = [
        'name',
        'address',
        'company_number',
        'contact_person',
        'contact_person_number'
    ];

    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'company_id');
    }

    public function masterDepartment(): HasMany
    {
        return $this->hasMany(MasterDepartment::class, 'company_id');
    }

    public function masterSection(): HasMany
    {
        return $this->hasMany(MasterSection::class, 'company_id');
    }
}
