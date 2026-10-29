<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends  BaseModel
{
    protected $guarded = [];
    use HasFactory;

    function category(){
        return $this->hasOne(CareerCategory::class,'id','category_id');
    }
}
