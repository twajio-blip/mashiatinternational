<?php

namespace App\Services\Career;

use App\Models\Career;
use Str;
use App\Models\CareerCategory;

class CategoryService
{



    public static function  Create(array $data)
    {
        $prepard = collect($data);
        $slug = Str::slug($prepard['name']);
        $prepard->merge(['slug'=> $slug]);
        CareerCategory::create($prepard->toArray());
    }
    public static function  Update(array $data, $id)
    {
        $prepard = collect($data);
        $slug = Str::slug($prepard['name']);
        $prepard->merge(['slug'=> $slug]);
        CareerCategory::where('id', $id)->update($prepard->toArray());
    }

    public static function  Delete($id)
    {
        $exists = Career::where('category_id', $id)->exists();
        if ($exists) {
            return false;
        }
        CareerCategory::where('id', $id)->delete();
        return true;
    }
}
