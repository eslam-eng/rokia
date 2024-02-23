<?php

namespace App\Models;

use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    use HasFactory,Filterable,EscapeUnicodeJson;
    protected $fillable = ['name','status'];
}
