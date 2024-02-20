<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookAppointment extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'therapist_id', 'date', 'time', 'day_id', 'price', 'status', 'user_description', 'notify'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class,'client_id');
    }

    public function therapist_id(): BelongsTo
    {
        return $this->belongsTo(Therapist::class,'therapist_id');
    }
}
