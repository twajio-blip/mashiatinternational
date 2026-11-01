<?php

namespace App\Services\Pages;

use App\Models\ComponentField;
use App\Models\Page;
use App\Models\PageComponent;
use App\Models\PageComponentStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class PagesService
{

    public static function create($data)
    {

        $prepared = collect($data);
        $current_id = self::createHiddenPage();
        if ($current_id) {
            self::update($data, $current_id);
        } else {
            $dataSet = imageProccess($data);
            if (isset($prepared['seo_image'])) {
                $dataSet = imageProccess($dataSet, '', 'seo_image');
            }
            if (isset($dataSet['is_breadcrumb'])) {
                $dataSet['is_breadcrumb'] = 1;
            } else {
                $dataSet['is_breadcrumb'] = 0;
            }
            $pages = Page::create($dataSet->except(['component_id', 'old_image', 'old_seo_image', 'display', 'page_id_for_status'])->toArray());
            $components = isset($prepared['component_id']) ?  $prepared['component_id']  : [];
            foreach ($components as $key => $value) {
                PageComponent::create([
                    'page_id' => $pages->id,
                    'component_master_id' => $value,
                    'limit' => $prepared['display'][$key],
                ]);
            }
        }
    }
    public static function update($data, $id)
    {
        $prepared = collect($data);

        $page = Page::where('id', $id)->first();

        $dataSet = imageProccess($data);
        if (isset($prepared['seo_image'])) {
            $dataSet = imageProccess($dataSet, $page->seo_image, 'seo_image');
        }
        // Dynamically process fields like 'image', 'seo_image', etc.
        $uploadFields = ['image', 'seo_image'];
        foreach ($uploadFields as $field) {
            if ($prepared->has("old_{$field}")) {
                $dataSet[$field] = null;
            }
        }
        // Breadcrumb toggle
        $dataSet['is_breadcrumb'] = $prepared->has('is_breadcrumb') ? 1 : 0;




        $page->update($dataSet->except(['component_id', 'old_image', 'old_seo_image', 'display', 'field_name', 'field_id', 'page_id_for_status', 'id'])->toArray());

        $components = isset($prepared['component_id']) ?  $prepared['component_id']  : [];
        PageComponent::where('page_id', $page->id)->delete();
        foreach ($components as $key => $value) {
            PageComponent::create([
                'page_id' => $page->id,
                'component_master_id' => $value,
                'limit' => $prepared['display'][$key],
            ]);
        }
    }
    public static function PagesUI(array $data)
    {
        DB::transaction(function () use ($data) {
            $prepared = collect($data)->all();

            // 1) Update only PARENT fields (no child/group management here anymore)
            if (isset($prepared['field_id'])) {
                $fieldlist   = $prepared['field_name']  ?? [];
                $fieldImages = $prepared['field_image'] ?? [];

                // Text / basic fields
                foreach ($fieldlist as $key => $value) {
                    if (isset($prepared['page_id'])) {
                        // Page-specific override: clone from template if needed
                        $parent = ComponentField::where('id', $prepared['field_id'][$key])
                            ->where('page_id', $prepared['page_id'])
                            ->first();

                        if ($parent) {
                            $parent->value   = $value;
                            $parent->page_id = $prepared['page_id'];
                            $parent->save();
                        } else {
                            $template = ComponentField::find($prepared['field_id'][$key]);
                            if ($template) {
                                ComponentField::create([
                                    'component_id' => $template->component_id,
                                    'name'         => $template->name,
                                    'type'         => $template->type,
                                    'value'        => $value,
                                    'page_id'      => (int) $prepared['page_id'],
                                ]);
                            }
                        }
                    } else {
                        // Update global template value
                        $field = ComponentField::find($prepared['field_id'][$key]);
                        if ($field) {
                            $field->value = $value;
                            $field->save();
                        }
                    }
                }

                // File / image fields
                foreach ($fieldImages as $key => $value) {
                    if (isset($prepared['page_id'])) {
                        $parent = ComponentField::where('id', $prepared['field_image_id'][$key])
                            ->where('page_id', $prepared['page_id'])
                            ->first();

                        if ($parent) {
                            $parent->update([
                                'value'   => $value,
                                'page_id' => $prepared['page_id'],
                            ]);
                        } else {
                            $template = ComponentField::where('id', $prepared['field_image_id'][$key])->first();
                            if ($template) {
                                ComponentField::create([
                                    'component_id' => $template->component_id,
                                    'name'         => $template->name,
                                    'type'         => $template->type,
                                    'value'        => $value,
                                    'page_id'      => (int) $prepared['page_id'],
                                ]);
                            }
                        }
                    } else {
                        $field = ComponentField::where('id', $prepared['field_image_id'][$key])->first();
                        if ($field) {
                            $field->update([
                                'value' => $value,
                            ]);
                        }
                    }
                }
            }

            // 2) Manage per-page component status & "Number of displays"
            // Priority for binding status:
            // 1) page_id_for_status (explicit target page)
            // 2) page_id (when editing existing page)
            // 3) hidden page (status = 3) for create-time previews
            $pageIdForStatus = null;
            if (!empty($prepared['page_id_for_status'])) {
                $pageIdForStatus = (int) $prepared['page_id_for_status'];
            } elseif (!empty($prepared['page_id'])) {
                $pageIdForStatus = (int) $prepared['page_id'];
            } else {
                // No real page yet -> use hidden page container
                $pageIdForStatus = self::createHiddenPage();
            }

            $componentId = $prepared['component_id'] ?? $prepared['id'] ?? null;
            if (is_array($componentId)) {
                $componentId = $componentId[0] ?? null;
            }

            if ($pageIdForStatus && $componentId) {
                $page_status = PageComponentStatus::where('page_id', $pageIdForStatus)
                    ->where('component_id', $componentId)
                    ->first();

                // If no display passed, default to 1 so frontend shows something
                $dataViewNo = isset($prepared['display']) && $prepared['display'] !== ''
                    ? (int) $prepared['display']
                    : 1;

                $payload = [
                    'status'       => (int) ($prepared['status'] ?? 0),
                    'data_view_no' => $dataViewNo,
                ];

                if ($page_status) {
                    $page_status->update($payload);
                } else {
                    PageComponentStatus::create($payload + [
                        'page_id'      => $pageIdForStatus,
                        'component_id' => $componentId,
                    ]);
                }

                // When adding to a real page (not hidden), create/update PageComponent so the component is on the page
                $realPageId = !empty($prepared['page_id']) ? (int) $prepared['page_id'] : null;
                if ($realPageId && $realPageId === $pageIdForStatus) {
                    $limit = isset($prepared['display']) && $prepared['display'] !== '' ? (int) $prepared['display'] : 1;
                    PageComponent::updateOrCreate(
                        [
                            'page_id' => $realPageId,
                            'component_master_id' => $componentId,
                        ],
                        ['limit' => $limit]
                    );
                }
            }
        });
    }
    public static function createHiddenPage()
    {

        $previous_hidden_page = Page::where('status', 3)->latest()->first();

        if ($previous_hidden_page) {
            return $previous_hidden_page->id;
        } else {
            $page = Page::create([
                'name' => '',
                'permalink' => '',
                'status' => 3
            ]);
            return $page->id;
        }
    }

    public static function Image($file, $oldimage)
    {
        if (is_file($file)) {
            // create image manager with desired driver
            $manager = new ImageManager(new Driver());
            // read image from file system
            $image = $manager->read($file);
            // save modified image in new format 
            // encode jpeg as webp format
            $encoded = $image->encode(new WebpEncoder(quality: 65)); // Intervention\Image\EncodedImage
            $encrypted =  md5($file) . '.webp';
            $encoded->save('images/' . $encrypted);
            if ($oldimage && isset($oldimage->value)) {
                $oldImagePath = 'images/' . $oldimage->value;
                if (file_exists($oldImagePath)) {
                    // The file exists, so unlink it
                    unlink($oldImagePath);
                }
            }
            return $encrypted;
        } else {
            return $file;
        }
    }
}
