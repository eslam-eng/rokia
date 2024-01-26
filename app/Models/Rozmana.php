<?php

namespace App\Models;

use App\Enums\UsersType;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rozmana extends Model
{
    use HasFactory,Filterable;

    protected $fillable = ['title','description','date','therapist_id','status'];

    public function therapist()
    {
        return $this->belongsTo(User::class,'therapist_id')->therapist();
    }

    public function scopeTherapist(Builder $builder)
    {
        return $builder->where('type',UsersType::THERAPIST->value);
    }
}
