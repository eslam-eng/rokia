<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Traits\HasMedia;

class MediaController extends Controller
{

    use HasMedia;
    public function deleteMedia(int $media_id)
    {
        try {
            $this->removeMediaById($media_id);
            return apiResponse(message: 'deleted successfully');
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 500);
        }
    }
}
