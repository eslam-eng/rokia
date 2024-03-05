<?php

namespace App\Models;

use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Interest extends Model
{
    use HasFactory,Filterable,EscapeUnicodeJson;
    protected $fillable = ['name','status'];

    public function rozmanas(): BelongsToMany
    {
        return $this->belongsToMany(Rozmana::class,'rozmana_interests','interest_id','rozmana_id');
    }
}
