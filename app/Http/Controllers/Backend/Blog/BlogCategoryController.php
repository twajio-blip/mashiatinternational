<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Services\Blog\CategoryService;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BlogCategory::orderByDesc('id')->get();
        return view('backend.pages.blog.category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        CategoryService::Create(filterRequest());
        return redirect()->back()->with('success', 'Data Inserted Successfully');
    }

    public function update(Request $request, string $id)
    {
        CategoryService::Update(filterRequest(), $id);
        return redirect()->back()->with('success', 'Data Update Successfully');
    }

    public function destroy(string $id)
    {

        $status =  CategoryService::Delete($id);
        if(!$status){
            return redirect()->back()->with('error', 'This Category has a post');
        }
        return redirect()->back()->with('success', 'Data Delete Successfully');
    }
}
