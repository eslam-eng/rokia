<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Therapist extends Authenticatable implements HasMedia
{
    use Filterable,HasApiTokens,
        HasFactory, Notifiable,HasRoles,InteractsWithMedia;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'type', 'status','therapist_commission',
        'device_token','address','city_id','area_id','locale','email_verified_at','avg_therapy_duration'
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
        return $this->belongsTo(Location::class,'city_id');
    }

    public function area()
    {
        return $this->belongsTo(Location::class,'area_id');
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class,'therapist_categories');
    }

    protected function mediaUrl() :Attribute
    {
        return Attribute::make(
            get: fn () =>!empty($this->getFirstMediaUrl()) ? $this->getFirstMediaUrl() : asset('assets/img/default_user.png'),
        );
    }

    public function schedules()
    {
        return $this->hasMany(TherapistSchedule::class,'therapist_id');
    }

    public function rozmans()
    {
        return $this->hasMany(Rozmana::class,'therapist_id');
    }


}
