<?php

namespace App\Http\Controllers\Backend\Work;

use App\Http\Controllers\Controller;
use App\Models\WorkCategory;
use App\Models\WorkPost;
use App\Services\Work\PostService;
use Illuminate\Http\Request;

class WorkPostController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = WorkCategory::orderByDesc('id')->get();
        $works= WorkPost::with('category')->orderByDesc('id')->paginate(10);
        return view('backend.pages.work.post.index', compact('categories','works'));
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
