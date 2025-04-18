<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'invoice_id', 'type', 'details', 'client_id', 'price',
        'discount', 'therapist_commission', 'notes'
    ];

    protected $casts = [
        'details' => 'json'
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    protected function detailsObject(): Attribute
    {
        return Attribute::make(
            get: fn() => json_decode($this->details)
        );
    }
}
