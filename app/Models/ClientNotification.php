<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'title',
        'body',
        'date',
        'time',
        'status',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class,'client_id');
    }
}
