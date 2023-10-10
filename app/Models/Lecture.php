<?php

namespace App\Models;

use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Lecture extends Model implements HasMedia
{
    use Filterable,EscapeUnicodeJson,InteractsWithMedia;

    protected $fillable = ['title', 'therapist_id', 'price', 'status', 'duration', 'description', 'type'];

    public function getImageCoverAttribute()
    {
        return $this->getMedia('*', ['type' => 'image'])->first()->getUrl();
    }

    public function getLectureContentAttribute()
    {
        return $this->getMedia('*', ['type' => 'mp3'])->first()->getUrl();
    }

    public function therapist(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'therapist_id');
    }

    public function wishlist()
    {
        return $this->morphMany(Wishlist::class, 'relatable');
    }
}
