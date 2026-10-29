<?php

namespace App\Services\Blog;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\GalleryCategory;

class CategoryService
{



    public static function  Create(array $data)
    {
        $prepard = collect($data);
        BlogCategory::create($prepard->toArray());
    }
    public static function  Update(array $data, $id)
    {
        $prepard = collect($data);
        BlogCategory::where('id', $id)->update($prepard->toArray());
    }

    public static function  Delete($id)
    {
        $exists = BlogPost::where('category_id', $id)->exists();
        if ($exists) {
            return false;
        }
        BlogCategory::where('id', $id)->delete();
        return true;
    }
}
