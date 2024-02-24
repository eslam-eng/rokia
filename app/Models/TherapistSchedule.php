<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function duration(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->start_time . __('app.therapists.schedules.to') . $this->end_time,
        );
    }
}
