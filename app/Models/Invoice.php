<?php

namespace App\Models;

use App\Enums\UsersType;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['therapist_id', 'sub_total', 'grand_total', 'therapist_due','status','compeleted_date'];

    public function therapist(): BelongsTo
    {
        return $this->belongsTo(Therapist::class);
    }

    public function InvoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class,'invoice_id');
    }

}
