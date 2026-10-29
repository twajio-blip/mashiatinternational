<?php

namespace App\Http\Controllers\Backend\Career;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\CareerCategory;
use App\Services\Career\CareerService;
use App\Services\Career\ImageService;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $careers = Career::with('category')->orderByDesc('id')->paginate(10);
        
        $categories = CareerCategory::get();

        return view('backend.pages.career.career.index',compact('careers','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // ImageService::Create(filterRequest());
        // return redirect()->back()->with('success','Data Inserted Successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        CareerService::Create(filterRequest());
        return redirect()->back()->with('success','Data Inserted Successfully');
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
        CareerService::Update(filterRequest(),$id);
        return redirect()->back()->with('success','Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Career $career)
    {
        $career->delete();
        return redirect()->back()->with('success','Data Deleted Successfully');
    }
}
