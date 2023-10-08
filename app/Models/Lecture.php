<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'user_id', 'price', 'status', 'duration', 'description', 'type'];

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
        return $this->belongsTo(User::class);
    }
}
