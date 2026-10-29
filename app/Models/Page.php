<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends BaseModel
{
    use HasFactory;
    protected $guarded = [];
    public function component()
    {
        // Keep components in the same order the user arranges them (drag & drop).
        // We recreate rows in that order in PagesService::create/update, so ordering
        // by the pivot table's primary key preserves the UI order.
        return $this->belongsToMany(ComponentMaster::class, 'page_components', 'page_id', 'component_master_id')
            ->with('componentFiled', 'componentFiledPageWise', 'limits')
            ->orderBy('page_components.id');
    }

    public function child()
    {
        return $this->hasMany(widgetChild::class, 'page_id', 'id');
    }

    public function pageStatus()
    {
        return $this->hasMany(PageComponentStatus::class, 'page_id', 'id');
    }
}
