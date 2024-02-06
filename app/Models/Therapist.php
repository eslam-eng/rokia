<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Therapist extends Authenticatable
{
    use Filterable,HasApiTokens,
        HasFactory, Notifiable,HasRoles,InteractsWithMedia;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'type', 'status','therapist_commission',
        'device_token','address','city_id','area_id','locale','email_verified_at'
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

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => bcrypt($value),
        );
    }
}
