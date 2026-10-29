<?php

namespace App\Http\Controllers\Backend\Career;

use App\Http\Controllers\Controller;
use App\Models\CareerCategory;
use App\Services\Career\CategoryService;
use Illuminate\Http\Request;

class CareerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CareerCategory::orderByDesc('id')->get();
        return view('backend.pages.career.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        CategoryService::Create(filterRequest());
        return redirect()->back()->with('success', 'Data Inserted Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        CategoryService::Update(filterRequest(),$id);
        return redirect()->back()->with('success', 'Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = CategoryService::Delete($id);
        if(!$status){
            return redirect()->back()->with('error', 'This Category has a Career');
        }
        return redirect()->back()->with('success', 'Data Deleted Successfully');
    }
}
