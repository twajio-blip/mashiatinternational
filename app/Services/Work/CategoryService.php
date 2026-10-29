<?php

namespace App\Services\Work;

use App\Models\WorkCategory;
use App\Models\WorkPost;
use App\Models\GalleryCategory;

class CategoryService
{
    public static function  Create(array $data)
    {
        $prepard = collect($data);
        WorkCategory::create($prepard->toArray());
    }
    public static function  Update(array $data, $id)
    {
        $prepard = collect($data);
        WorkCategory::where('id', $id)->update($prepard->toArray());
    }

    public static function  Delete($id)
    {
        $exists = WorkPost::where('category_id', $id)->exists();
        if ($exists) {
            return false;
        }
        WorkCategory::where('id', $id)->delete();
        return true;
    }
}
