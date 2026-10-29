<?php

namespace App\Services\Services;

use App\Models\Services;
use App\Models\ServiceImages;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class ServiceService
{

    public static function  ServicesCreate(array $data)
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
        $prepard = $collect->except('image','images');
        $prepard =  $prepard->merge(['image' => $encrypted]);
        $service=Services::create($prepard->toArray());
        $images= isset($collect['images'] ) ? $collect['images'] : [];
        foreach($images as $value){
            $manager = new ImageManager(new Driver());
            // read image from file system
            $image = $manager->read($value);
            // save modified image in new format 
            // encode jpeg as webp format
            $encoded = $image->encode(new WebpEncoder(quality: 65)); // Intervention\Image\EncodedImage
            $encrypted =  md5($value) . '.webp';
            $encoded->save('images/' . $encrypted);

            ServiceImages::create([
                'image' => $encrypted,
                'service_id' => $service->id,
            ]);
        }
    }
    public static function  ServicesUpdate(array $data, $id)
    {
        $collect = collect($data);

        $services = Services::where('id', $id)->first();
        // create image manager with desired driver

        if (!empty($collect['image'])) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($collect['image']);

            $encoded = $image->encode(new WebpEncoder(quality: 65)); // Intervention\Image\EncodedImage
            $encrypted =  md5($collect['image']) . '.webp';
            $encoded->save('images/' . $encrypted);
            $prepard = $collect->except('image','images');
            $prepard =  $prepard->merge(['image' => $encrypted]);
            unlink('images/' . $services->image);
        } else {
            $prepard = $collect->except('image','images');
            $prepard =  $prepard->merge(['image' => $services->image]);
        }

        $services->update($prepard->toArray());

        $images= isset($collect['images'] ) ? $collect['images'] : [];
        foreach($images as $value){
            $manager = new ImageManager(new Driver());
            // read image from file system
            $image = $manager->read($value);
            // save modified image in new format 
            // encode jpeg as webp format
            $encoded = $image->encode(new WebpEncoder(quality: 65)); // Intervention\Image\EncodedImage
            $encrypted =  md5($value) . '.webp';
            $encoded->save('images/' . $encrypted);

            ServiceImages::create([
                'image' => $encrypted,
                'service_id' => $id,
            ]);
        }
    }
}