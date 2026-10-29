<?php

namespace App\Services\Faq;

use App\Models\Faq;
use App\Models\Services;


class FaqService
{

    public static function  faqCreate(array $data)
    {
        $prepard = collect($data);

        Faq::create($prepard->toArray());
    }
    public static function  faqUpdate(array $data, $id)
    {
        $prepard = collect($data);
        $Faq = Faq::where('id', $id)->first();
        $Faq->update($prepard->toArray());
    }
}
