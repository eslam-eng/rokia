<?php

namespace App\Traits;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasMedia
{

    private function removeMediaById($media_id)
    {
        $mediaItem = Media::find($media_id);
        return $mediaItem?->delete();
    }
}
