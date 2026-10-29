<?php

namespace App\Services\Contact;

use App\Models\Contact;



class ContactService
{
    public static function  update($id)
    {
        Contact::where('id', $id)->update([
            'status'=> 1
        ]);
    }
    public static function  updateAll()
    {
        Contact::query()->update([
            'status' => 1
        ]);
    }
}