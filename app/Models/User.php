<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nip',
        'name',
        'email',
        'password',
        'address',
        'position',
        'company_id',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function masterRole(): BelongsTo
    {
        return $this->belongsTo(MasterRole::class, 'role_id');
    }

    public function masterCompany(): BelongsTo
    {
        return $this->belongsTo(MasterCompany::class, 'company_id');
    }



    public function procurementHeader()
    {
        return $this->hasMany(TransactionItemProcurementHeader::class, 'user_id');
    }

    public function incomingItem(): HasMany
    {
        return $this->hasMany(TransactionIncomingItem::class, 'user_id');
    }

    public function outgoingItem()
    {
        return $this->hasMany(TransactionOutgoingItem::class, 'user_id');
    }

    public function itemMovementHeader()
    {
        return $this->hasMany(TransactionItemMovementHeader::class, 'user_id');
    }
}
