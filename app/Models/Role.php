<?php

namespace App\Models;

use App\Enums\ActivationStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends \Spatie\Permission\Models\Role
{
    protected $primaryKey = 'id';

    const SUPER_ADMIN = 'Super Admin';

    protected $fillable = [
        'name',
        'guard_name',
        'is_active',
    ];

    public function scopeSuperAdmin(Builder $builder)
    {
        return $builder->where('name', self::SUPER_ADMIN);
    }

    public function scopeNotSuperAdmin(Builder $builder)
    {
        return $builder->where('name', '!=', self::SUPER_ADMIN);
    }

    public function getStatusTextAttribute()
    {
        return ActivationStatus::from($this->is_active)->getLabel();
    }

    public function isSuperAdminRole(): bool
    {
        return $this->name === self::SUPER_ADMIN;
    }
}
