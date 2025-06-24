<?php

namespace App\Helpers;
use Intervention\Image\Filters\FilterInterface;

class ImageFilter implements FilterInterface
{
    


    /**
     * Applies filter effects to given image
     *
     * @param  Intervention\Image\Image $image
     * @return Intervention\Image\Image
     */
    public function applyFilter(\Intervention\Image\Image $image)
    {
       return $image->fit(400, 400)
        ->blur(5)
        ->greyscale();
    }
}