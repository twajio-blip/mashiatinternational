<?php

namespace App\Services\Career;

use App\Models\Career;
use App\Models\GalleryImage;

class CareerService
{

    public static function  Create(array $data)
    {
        Career::create(collect($data)->toArray());
    }
    public static function  Update(array $data, $id)
    {
        Career::where('id',$id)->update(collect($data)->toArray());
    }
    public static function  Delete($id)
    {
        
        $oldData = GalleryImage::where('id', $id)->first();
        $oldData->delete();
    }
}
