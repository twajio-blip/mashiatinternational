<?php

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Drivers\Gd\Encoders\WebpEncoder;
use App\Models\Language;
use App\Models\Notifications;
use App\Models\Translation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

function formatNumberShort($number)
{
    if ($number >= 1_000_000_000) {
        return rtrim(rtrim(number_format($number / 1_000_000_000, 1), '0'), '.') . 'B';
    } elseif ($number >= 1_000_000) {
        return rtrim(rtrim(number_format($number / 1_000_000, 1), '0'), '.') . 'M';
    } elseif ($number >= 1_000) {
        return rtrim(rtrim(number_format($number / 1_000, 1), '0'), '.') . 'K';
    }
    return (string) $number;
}

if (!function_exists("input")) {
    function input()
    {
        return [
            'text' => 'text',
            'number' => 'number',
            'textarea' => 'textarea',
            'file' => 'file',
            'upload' => 'upload (single file/image)',
            'upload_multi' => 'upload (multiple files/images)',
            'button' => 'button',
            'textEditor' => 'textEditor',
            'checkBox' => 'checkBox',
            'select' => 'select (Dropdown with static options)',
            'belongsTo' => 'belongsTo (Many-to-One)',
            'hasOne' => 'hasOne (One-to-One)',
            'hasMany' => 'hasMany (One-to-Many)',
        ];
    }
}

if (!function_exists("imageComprese")) {
    function imageComprese($image)
    {

        // create image manager with desired driver
        $manager = new ImageManager(new Driver());

        // read image from file system
        $compressedImage = $manager->read($image);
        // save modified image in new format 
        // encode jpeg as webp format

        $encoded = $compressedImage->encode(new WebpEncoder(quality: 65)); // Intervention\Image\EncodedImage
        $encrypted =  md5($image) . '.webp';
        $encoded->save('images/' . $encrypted);
        return $encrypted;
    }
}

if (!function_exists("imageProccess")) {
    function imageProccess($data, $oldimage = false, $column = 'image')
    {
        $collect = collect($data);
        if (isset($collect[$column])) {
            $encrypted = imageComprese($collect[$column]);
            $prepared = $collect->except($column)->merge([$column => $encrypted]);
            if ($oldimage) {
                if (file_exists('images/' . $oldimage)) {
                    unlink('images/' . $oldimage);
                }
            }
        } else {
            $prepared = $collect->except($column);
        }

        if (isset($collect[$column])  && empty($collect[$column]) &&  $oldimage) {
            if ($oldimage) {
                if (file_exists('images/' . $oldimage)) {
                    unlink('images/' . $oldimage);
                }
            }
        }

        return $prepared;
    }
}



if (!function_exists("filterRequest")) {
    function filterRequest(array $data = [])
    {
        return  request()->except('proengsoft_jsvalidation', '_token', '_method', 'save', 'save_exit','preview', ...$data);
    }
}

/**
 * Build data-details-view (data-view) URL. Accepts item array (auto) or (id, pageId, group).
 * Array keys: component_id, current_page_id, group (or _component_id, _current_page_id, _group, _record_id).
 */
if (!function_exists('data_details_view_url')) {
    function data_details_view_url($itemOrId, $currentPageId = 0, $group = null): string
    {
        if (is_array($itemOrId)) {
            $id = (int) ($itemOrId['component_id'] ?? $itemOrId['_component_id'] ?? 0);
            $currentPageId = (int) ($itemOrId['current_page_id'] ?? $itemOrId['_current_page_id'] ?? 0);
            $group = $itemOrId['group'] ?? $itemOrId['_group'] ?? $itemOrId['_record_id'] ?? null;
        } else {
            $id = (int) $itemOrId;
            $currentPageId = (int) $currentPageId;
        }
        $url = route('data-view', ['id' => $id, 'current_page_id' => $currentPageId]);
        if ($group !== null && $group !== '') {
            $url .= '?group=' . rawurlencode((string) $group);
        }
        return $url;
    }
}

/**
 * Merge instance + section, set _url. Returns one item. Use for any component/section.
 */
if (!function_exists('data_details_view_item')) {
    function data_details_view_item(array $instance, array $section, $defaultComponentId = null, $defaultPageId = null): array
    {
        $item = array_merge($instance, [
            'component_id' => $section['component_id'] ?? $defaultComponentId,
            'current_page_id' => $section['current_page_id'] ?? $defaultPageId ?? 0,
            'group' => $section['group'] ?? $instance['_record_id'] ?? null,
        ]);
        $item['_url'] = data_details_view_url($item);
        return $item;
    }
}

/**
 * From full batch $data, get all items for a group name with _url set.
 * All extra preparation (merge sibling groups, decode JSON) is handled here.
 *
 * @param array $data full component batch
 * @param string $groupName group_name to collect (e.g. 'Products', 'Portfolio')
 * @param array $options optional: 'merge_group' => sibling group_name to merge (e.g. 'Portfolio_Details');
 *                        'decode_json' => list of keys to decode from JSON string to array (e.g. ['images'])
 * @return array list of items (instance + component_id, current_page_id, group, _url; plus merged/decoded fields)
 */
if (!function_exists('data_prepared_items')) {
    function data_prepared_items(array $data, string $groupName, array $options = []): array
    {
        $items = [];
        $componentId = $data['component_id'] ?? 6;
        $componentLimit = isset($data['limit']) ? (int) $data['limit'] : 0;
        $outputLimit = isset($options['limit']) ? (int) $options['limit'] : $componentLimit;
        $pageId = null;
        $mergeGroup = $options['merge_group'] ?? null;
        $decodeJsonKeys = $options['decode_json'] ?? [];

        foreach ($data as $key => $section) {
            if (!is_array($section)) {
                continue;
            }
            if ($pageId === null) {
                $pageId = $section['current_page_id'] ?? null;
            }
            foreach ($section as $subKey => $group) {
                if (!is_array($group) || ($group['group_name'] ?? '') !== $groupName) {
                    continue;
                }

                // Determine base records: either nested instances[] or the group itself
                $instances = $group['instances'] ?? null;
                $records = (is_array($instances) && count($instances) > 0) ? $instances : [$group];

                foreach ($records as $instance) {
                    $item = data_details_view_item($instance, $section, $componentId, $pageId);

                    // Merge sibling group (e.g. Portfolio_Details) if requested
                    if ($mergeGroup !== null && $mergeGroup !== '') {
                        foreach ($section as $sibling) {
                            if (!is_array($sibling) || ($sibling['group_name'] ?? '') !== $mergeGroup) {
                                continue;
                            }
                            $extra = $sibling;
                            unset($extra['group_name']);
                            $item = array_merge($item, $extra);
                            break;
                        }
                    }

                    // Decode JSON keys if requested
                    foreach ($decodeJsonKeys as $k) {
                        if (!array_key_exists($k, $item)) {
                            continue;
                        }
                        $raw = $item[$k];
                        if (is_string($raw)) {
                            $decoded = json_decode($raw, true);
                            $item[$k] = is_array($decoded) ? $decoded : [];
                        } elseif (!is_array($item[$k])) {
                            $item[$k] = [];
                        }
                    }

                    $items[] = $item;
                }
            }
        }

        if ($outputLimit > 0) {
            return array_slice($items, 0, $outputLimit);
        }

        return $items;
    }
}


// Cache Clear
if (!function_exists('clear_cache')) {
    function clear_cache()
    {
        Artisan::call('optimize:clear');
    }
}


// update Notification
if (!function_exists('updateNotification')) {
    function updateNotification($id, $type)
    {
        Notifications::where('type_id', $id)->where('type', $type)->update([
            'is_read' => 1
        ]);
    }
}
// update Notification
if (!function_exists('updateNotification')) {
    function updateNotification($id, $type)
    {
        Notifications::where('type_id', $id)->where('type', $type)->update([
            'is_read' => 1
        ]);
    }
}


if (!function_exists('getTranslation')) {
    function getHeaderFooter()
    {
        // get all header and footer files
        $headerFile = File::allFiles(base_path('resources/views/components/frontend/header'));
        $footerFile = File::allFiles(base_path('resources/views/components/frontend/footer'));

        return collect([
            'header' => preparedHeaderFooterSettings($headerFile),
            'footer' => preparedHeaderFooterSettings($footerFile),
        ]);
    }
}
if (!function_exists('preparedHeaderFooterSettings')) {
    function preparedHeaderFooterSettings($src)
    {
        // Header array
        $data = [];
        foreach ($src as $file) {
            $filename = $file->getFilename();

            // Step 1: Remove .blade.php
            $nameWithoutExtension = str_replace('.blade.php', '', $filename);

            // Step 2: Insert spaces before capital letters (CamelCase split)
            $spacedName = preg_replace('/(?<!^)([A-Z])/', ' $1', $nameWithoutExtension);
            // Step 3: Make it lowercase and capitalize words
            $formatted = ucwords(strtolower($spacedName));
            $data[] = ['level' => $formatted, 'value' => $nameWithoutExtension];
        }

        return $data;
    }
}
