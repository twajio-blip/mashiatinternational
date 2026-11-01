<?php

namespace App\Services\Theme;

use App\Models\FooterGroup;
use App\Models\FooterGroupDetails;
use App\Models\General;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class ThemeService
{

    public static function  CreateGeneral(array $data)
    {
        $prepared = collect($data);
        $general = General::first();

        if (isset($prepared['applyCookie']) == false) {
            $prepared = $prepared->except(['cookie_title', 'cookie_description', 'applyCookie']);
            $prepared = $prepared->merge(['cookie_title' => null, 'cookie_description' => null]);
        } else {
            $prepared = $prepared->except('applyCookie');
        }



        if ($general) {
            $general->update($prepared->all());
        } else {
            General::create($prepared->all());
        }
    }
    public static function CreateLogo(array $data)
    {
        $general = General::first();
        $dataSet = $data;
        $imageFields = ['fav_icon', 'header', 'footer'];
        foreach ($imageFields as $field) {
            if (isset($data[$field])) {
                $oldImage = $general ? $general->$field : null;
                $dataSet = imageProccess($dataSet, $oldImage, $field);
            }
        }
        $payload = is_array($dataSet) ? $dataSet : $dataSet->toArray();
        if ($general) {
            $general->update($payload);
        } else {
            General::create($payload);
        }
    }
    public static function CreateSocial($data)
    {
        $collect = collect($data);
        $store = [];
        foreach ($collect['icone'] as $key => $value) {
            $store[] = [$collect['icone'][$key], $collect['link'][$key], $collect['name'][$key]];
        }
        $data =   json_encode($store);
        $general = General::first();
        if ($general) {
            $general->update([
                'social' => $data
            ]);
        } else {
            General::create([
                'social' => $data
            ]);
        }
    }
    public static function CreateFooterLink($data)
    {
        $groupNames = $data['groupName'] ?? [];
        $linkNames = $data['linkName'] ?? [];
        $linkUrls = $data['linkUrl'] ?? [];
        $linkIcons = $data['linkIcon'] ?? [];

        FooterGroupDetails::truncate();
        FooterGroup::truncate();

        foreach ($groupNames as $key => $groupName) {
            $groupNum = (int) $key + 1;
            $footerGroupId = FooterGroup::create(['name' => $groupName]);

            $names = $linkNames[$groupNum] ?? [];
            $urls = $linkUrls[$groupNum] ?? [];
            $icons = $linkIcons[$groupNum] ?? [];

            foreach ($names as $index => $name) {
                FooterGroupDetails::create([
                    'footer_group_id' => $footerGroupId->id,
                    'name' => $name,
                    'url' => $urls[$index] ?? '',
                    'icon' => $icons[$index] ?? '',
                ]);
            }
        }
    }
}
