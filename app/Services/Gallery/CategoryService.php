<?php

namespace App\Services\Gallery;

use App\Models\GalleryCategory;
use App\Models\GalleryImage;

class CategoryService
{



    public static function  Create(array $data)
    {

        $prepard = imageProccess($data);
        GalleryCategory::create($prepard->toArray());
    }
    public static function  Update(array $data, $id)
    {
        $oldData = GalleryCategory::where('id', $id)->first();
        $prepard = imageProccess($data, $oldData->image);
        $oldData->update($prepard->toArray());
    }

    public static function  Delete($id)
    {
        $exists = GalleryImage::where('category_id', $id)->exists();
        if ($exists) {
            return false;
        }
        $oldData= GalleryCategory::where('id', $id)->first();
        $prepard = imageProccess([], $oldData->image);
        $oldData->delete();
        return true;
    }
}
