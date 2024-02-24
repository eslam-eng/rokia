<?php

namespace App\Models;

use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TherapistPlan extends Model
{
    use HasFactory,Filterable,EscapeUnicodeJson;

    protected $fillable = ['therapist_id','name','duration','price','status'];

    public function therapist(): BelongsTo
    {
        return $this->belongsTo(Therapist::class);
    }
}
