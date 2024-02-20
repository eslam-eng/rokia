<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use Filterable, HasApiTokens,
        HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'type', 'status',
        'gender', 'device_token', 'address', 'city_id', 'area_id', 'locale'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function profileImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => !empty($this->getFirstMediaUrl('profile_image')) ? $this->getFirstMediaUrl('profile_image') : asset('assets/img/default_user.png'),
        );
    }


    public function getToken(): string
    {
        return $this->createToken(config('app.name'))->plainTextToken;
    }

    public function city()
    {
        return $this->belongsTo(Location::class, 'city_id');
    }

    public function area()
    {
        return $this->belongsTo(Location::class, 'area_id');
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(Role::SUPER_ADMIN);
    }

    public function lecture(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Lecture::class, 'user_lectures');
    }
}
