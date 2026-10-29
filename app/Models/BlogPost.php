<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends  BaseModel
{
    use HasFactory;
    
    protected $guarded=[];
    
    function category(){
        return $this->hasOne(BlogCategory::class,'id','category_id');
    }
}
