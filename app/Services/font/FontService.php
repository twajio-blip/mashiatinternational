<?php

namespace App\Services\Font;

use App\Models\Font;
use App\Models\Services;


class FontService
{

    public static function  fontCreate(array $data)
    {
        $prepard = collect($data);
        $prepard['is_frontend'] = 0;
        $prepard['is_backend'] = 0;

        if (isset($prepard['is_frontend'])) {
            Font::where('is_frontend', 1)->update([
                'is_frontend' => 0
            ]);
            $prepard['is_frontend'] = 1;
        }
        if (isset($prepard['is_backend'])) {
            Font::where('is_backend', 1)->update([
                'is_backend' => 0
            ]);
            $prepard['is_backend'] = 1;
        }
        Font::create($prepard->toArray());
    }
    public static function  fontUpdate(array $data, $id)
    {

        $prepard = collect($data);



        if (isset($prepard['is_frontend'])) {
            Font::where('is_frontend', 1)->update([
                'is_frontend' => 0
            ]);

            $prepard['is_frontend'] = 1;
        } else {
            $prepard['is_frontend'] = 0;
        }

        if (isset($prepard['is_backend'])) {
            Font::where('is_backend', 1)->update([
                'is_backend' => 0
            ]);

            $prepard['is_backend'] = 1;
        } else {
            $prepard['is_backend'] = 0;
        }

        $font = Font::where('id', $id)->first();
        $font->update($prepard->toArray());
    }
}
