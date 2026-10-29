<?php

namespace App\Services\Blog;

use App\Models\BlogPost;


class PostService
{

    public static function  Create(array $data)
    {
        $prepared = imageProccess($data, false, 'author_image');
        $prepared = imageProccess($prepared);
        
      
        BlogPost::create($prepared->toArray());
    }
    public static function  Update(array $data, $id)
    {
        $oldData = BlogPost::where('id', $id)->first();
        $prepard = imageProccess($data, $oldData->image);
        $oldData->update($prepard->toArray());
    }
    public static function  Delete($id)
    {
        $oldData = BlogPost::where('id', $id)->first();
        $prepard = imageProccess([], $oldData->image);
        $oldData->delete();
    }
}
