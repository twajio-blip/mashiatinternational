<?php

namespace App\Services\Widget;

use App\Models\Faq;
use App\Models\Services;
use App\Models\widget;
use App\Models\widgetChild;

class WidgetService
{
    public static function update(array $data)
    {


        Widget::truncate(); // Clear existing data (optional based on use case)
        $prepared = json_decode($data['items'], true);
        self::saveWidgetsRecursively($prepared);
    }

    private static function saveWidgetsRecursively(array $items, $parentId = null)
    {

 
        foreach ($items as $position => $item) {
            $widget = Widget::create([
                'link' => $item['link'],
                'name' => $item['name'],
                'type' => $item['type'],
                'ref_id' => ($item['id'] == null || $item['id'] == '') ? null : $item['id'],
                'parent_id' => $parentId,
                'position' => $position,
            ]);

            if (!empty($item['children'])) {
                self::saveWidgetsRecursively($item['children'], $widget->id);
            }
        }
    }
}
