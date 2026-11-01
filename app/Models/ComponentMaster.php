<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ComponentMaster extends BaseModel
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'schema_group_settings' => 'array',
        'related_data' => 'array',
        'is_single' => 'boolean',
        'is_connected' => 'boolean',
        'data_source_component_id' => 'integer',
    ];
    public function componentFiled()
    {
        return $this->hasMany(ComponentField::class, 'component_id', 'id')->orderby('group', 'asc')->whereNull('page_id')->orderby('position', 'asc');
    }
    public function componentFiledPageWise()
    {
        return $this->hasMany(ComponentField::class, 'component_id', 'id')->orderby('group', 'asc')->whereNotNull('page_id')->orderby('position', 'asc');
    }
    public function limits()
    {
        return $this->hasOne(PageComponent::class, 'component_master_id', 'id')->select('limit', 'component_master_id');
    }
    public function pageStatus()
    {
        return $this->hasOne(PageComponentStatus::class, 'component_id', 'id');
    }

    public function dataSource()
    {
        return $this->belongsTo(self::class, 'data_source_component_id');
    }
}
