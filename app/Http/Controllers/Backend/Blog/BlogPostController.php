<?php

namespace App\Http\Controllers\Backend\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Services\Blog\PostService;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BlogCategory::orderByDesc('id')->get();
        $blogs= BlogPost::with('category')->orderByDesc('id')->paginate(10);
        return view('backend.pages.blog.post.index', compact('categories','blogs'));
    }

    public function store(Request $request)
    {
        PostService::Create(filterRequest());
        return redirect()->back()->with('success', 'Data Inserted Successfully');
    }

    public function update(Request $request, string $id)
    {
        PostService::Update(filterRequest(), $id);
        return redirect()->back()->with('success', 'Data Update Successfully');
    }

    public function destroy(string $id)
    {
        PostService::Delete($id);
        return redirect()->back()->with('success', 'Data Delete Successfully');
    }
}
