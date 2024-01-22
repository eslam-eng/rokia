<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Slider extends Model implements HasMedia
{
    use InteractsWithMedia,HasFactory,Filterable;

    protected $fillable = ['caption','order', 'status'];

    protected function mediaUrl() :Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMediaUrl()
        );
    }

}
