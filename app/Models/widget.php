<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class widget extends  BaseModel
{
    use HasFactory;
    protected $guarded = [];
    public function page()
    {
        return $this->hasOne(Page::class, 'id', 'page_id')->with('child');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('position')->with('children');
    }
}
