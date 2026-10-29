<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends  BaseModel
{
    protected $guarded = [];
    use HasFactory;

    function category(){
        return $this->hasOne(GalleryCategory::class,'id','category_id');
    }
}
