<?php

namespace App\Services\Company;

use App\Models\Company;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;



class CompanyService
{

    public static function  Create(array $data)
    {
        Company::create(imageProccess($data)->toArray());
    }
    public static function  update(array $data, $id)
    {
        Company::where('id', $id)->update(imageProccess($data)->toArray());
    }
}
