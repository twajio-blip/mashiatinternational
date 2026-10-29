<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkPost extends  BaseModel
{
    use HasFactory;
    
    protected $guarded=[];
    
    function category(){
        return $this->hasOne(WorkCategory::class,'id','category_id');
    }
}
