<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['invoice_id', 'lecture_id', 'client_id', 'price',
        'discount', 'therapist_commission', 'notes'
    ];

    public function invoice(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Invoice::class,'invoice_id');
    }
}
