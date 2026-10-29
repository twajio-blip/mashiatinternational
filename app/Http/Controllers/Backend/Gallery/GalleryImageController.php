<?php

namespace App\Http\Controllers\Backend\Gallery;

use Illuminate\Http\Request;
use App\Models\GalleryCategory;
use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use App\Services\Gallery\ImageService;

class GalleryImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gallery = GalleryImage::with('category')->orderByDesc('id')->paginate(10);
        $categories = GalleryCategory::get();
        
        return view('backend.pages.gallery.images.index',compact('gallery','categories'));
    }

  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     
        ImageService::Create(filterRequest());
        return redirect()->back()->with('success','Data Inserted Successfully');
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        ImageService::Update(filterRequest(),$id);
        
        return redirect()->back()->with('success','Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ImageService::Delete($id);
        return redirect()->back()->with('success','Data Deleted Successfully');
    }
}
