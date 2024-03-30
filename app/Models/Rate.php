<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Rate extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['user_id', 'relatable_id', 'relatable_type', 'rate_number', 'comment'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function relatable(): MorphTo
    {
        return $this->morphTo();
    }


}
