<?php

namespace App\Services\Slider;

use App\Models\Slider;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class SliderService
{

    public static function  sliderCreate(array $data)
    {
        $collect = collect($data);
        // create image manager with desired driver
        $manager = new ImageManager(new Driver());

        // read image from file system
        $image = $manager->read($collect['image']);
        // save modified image in new format 
        // encode jpeg as webp format

        $encoded = $image->encode(new WebpEncoder(quality: 65)); // Intervention\Image\EncodedImage
        $encrypted =  md5($collect['image']) . '.webp';
        $encoded->save('images/' . $encrypted);
        $prepard = $collect->except('image');
        $prepard =  $prepard->merge(['image' => $encrypted]);
        Slider::create($prepard->toArray());
    }
    public static function  sliderUpdate(array $data, $id)
    {
        $collect = collect($data);

        $slide = Slider::where('id', $id)->first();
        // create image manager with desired driver

        if (!empty($collect['image'])) {
            $manager = new ImageManager(new Driver());
            // read image from file system
            $image = $manager->read($collect['image']);
            // save modified image in new format 
            // encode jpeg as webp format

            $encoded = $image->encode(new WebpEncoder(quality: 65)); // Intervention\Image\EncodedImage
            $encrypted =  md5($collect['image']) . '.webp';
            $encoded->save('images/' . $encrypted);
            $prepard = $collect->except('image');
            $prepard =  $prepard->merge(['image' => $encrypted]);
            unlink('images/' . $slide->image);
        } else {
            $prepard = $collect->except('image');
            $prepard =  $prepard->merge(['image' => $slide->image]);
        }

        $slide->update($prepard->toArray());
    }
}
