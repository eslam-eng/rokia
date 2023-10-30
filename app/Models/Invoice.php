<?php

namespace App\Models;

use App\Enums\UsersType;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['therapist_id', 'sub_total', 'grand_total', 'therapist_due','status'];

    public function therapist(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'therapist_id')->where('type',UsersType::THERAPIST->value);
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(InvoiceItem::class,'invoice_id');
    }

}
