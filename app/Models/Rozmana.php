<?php

namespace App\Models;

use App\Enums\UsersType;
use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rozmana extends Model
{
    use HasFactory,Filterable,EscapeUnicodeJson;

    protected $fillable = ['title','description','date','therapist_id','status'];

    public function therapist(): BelongsTo
    {
        return $this->belongsTo(User::class,'therapist_id');
    }

    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Interest::class,'rozmana_interests','rozmana_id','interest_id');
    }
}
