<?php

namespace App\Models;

use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TherapistPlan extends Model
{
    use HasFactory,Filterable,EscapeUnicodeJson,SoftDeletes;

    protected $fillable = ['therapist_id','name','roznama_number','price','status'];

    public function therapist(): BelongsTo
    {
        return $this->belongsTo(Therapist::class);
    }
    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Interest::class,'therapist_plan_interests','therapist_plan_id','interest_id');
    }
}
