<?php

namespace App\Models;

use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TherapistPlan extends Model
{
    use HasFactory,Filterable,EscapeUnicodeJson,SoftDeletes;

    protected $fillable = ['therapist_id','name','duration','price','status'];

    public function therapist(): BelongsTo
    {
        return $this->belongsTo(Therapist::class);
    }
}
