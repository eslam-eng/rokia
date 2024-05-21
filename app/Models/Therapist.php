<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class Therapist extends Authenticatable implements HasMedia
{
    use Filterable, HasApiTokens,
        HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'status', 'therapist_commission', 'status','therapy_price',
        'device_token', 'address', 'city_id', 'area_id', 'locale', 'email_verified_at', 'avg_therapy_duration'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    public function specialists(): BelongsToMany
    {
        return $this->belongsToMany(Specialist::class, 'therapist_specialists');
    }

    protected function profileImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => !empty($this->getFirstMediaUrl('profile_image')) ? $this->getFirstMediaUrl('profile_image') : asset('assets/img/default_user.png'),
        );
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(TherapistSchedule::class, 'therapist_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(BookAppointment::class,'therapist_id');
    }

    public function rozmans(): HasMany
    {
        return $this->hasMany(Rozmana::class, 'therapist_id');
    }

    public function lectures(): HasMany
    {
        return $this->hasMany(Lecture::class, 'therapist_id');
    }


}
