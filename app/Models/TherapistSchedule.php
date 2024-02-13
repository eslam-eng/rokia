<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TherapistSchedule extends Model
{
    use HasFactory,Filterable;
    protected $fillable = ['day_id','start_time','end_time','therapist_id'];

    public function therapist(): BelongsTo
    {
        return $this->belongsTo(Therapist::class,'therapist_id');
    }
}
