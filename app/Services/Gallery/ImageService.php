<?php

namespace App\Services\Gallery;

use App\Models\GalleryImage;

class ImageService
{

    public static function  Create(array $data)
    {
        $collect = collect($data);
        $prepared = [];
        foreach ($collect['image'] as $key => $value) {
            $prepared[] = ['category_id' => $collect['category_id'],'caption_title' => $collect['caption_title'],'caption_sub_title' => $collect['caption_sub_title'],  ...imageProccess(['image' => $value])];
        }
        // dd($prepared);
        GalleryImage::insert($prepared);
    }
    public static function  Update(array $data, $id)
    {
        $oldData = GalleryImage::where('id', $id)->first();
        $prepard = imageProccess($data, $oldData->image);
        $oldData->update($prepard->toArray());
    }
    public static function  Delete($id)
    {
        $oldData = GalleryImage::where('id', $id)->first();
        $prepard = imageProccess([], $oldData->image);
        $oldData->delete();
    }
}
