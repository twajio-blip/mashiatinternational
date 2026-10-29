<?php

namespace App\Services\Work;

use App\Models\WorkPost;


class PostService
{

    public static function  Create(array $data)
    {

        $prepared = imageProccess($data);
      
        WorkPost::create($prepared->toArray());
    }
    public static function  Update(array $data, $id)
    {
        $oldData = WorkPost::where('id', $id)->first();
        $prepard = imageProccess($data, $oldData->image);
        $oldData->update($prepard->toArray());
    }
    public static function  Delete($id)
    {
        $oldData = WorkPost::where('id', $id)->first();
        $prepard = imageProccess([], $oldData->image);
        $oldData->delete();
    }
}
