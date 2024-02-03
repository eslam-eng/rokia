<?php

namespace App\Models;

use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory,Filterable,EscapeUnicodeJson;
    protected $fillable = ['name','status'];

}
