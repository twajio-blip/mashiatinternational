<?php

namespace App\Http\Controllers\Backend\Gallery;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use App\Services\Gallery\CategoryService;
use Illuminate\Http\Request;

class GalleryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = GalleryCategory::orderByDesc('id')->get();
        return view('backend.pages.gallery.category.index', compact('categories'));
    }


    public function store(Request $request)
    {
        CategoryService::Create(filterRequest());
        return redirect()->back()->with('success', 'Data Inserted Successfully');
    }


    public function update(Request $request, string $id)
    {
        CategoryService::Update(filterRequest(), $id);
        return redirect()->back()->with('success', 'Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = CategoryService::Delete($id);
        if(!$status){
            return redirect()->back()->with('error', 'This Category has an image');
        }
        return redirect()->back()->with('success', 'Data Deleted Successfully');
    }
}
