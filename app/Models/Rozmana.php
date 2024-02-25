<?php

namespace App\Models;

use App\Enums\UsersType;
use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rozmana extends Model
{
    use HasFactory,Filterable,EscapeUnicodeJson;

    protected $fillable = ['title','description','date','therapist_id','status','interests'];

    protected $casts =[
      'interests'=>'array'
    ];
    public function therapist(): BelongsTo
    {
        return $this->belongsTo(User::class,'therapist_id');
    }
}
