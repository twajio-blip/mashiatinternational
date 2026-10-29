<?php

namespace App\Http\Controllers\Backend\Font;

use App\Http\Controllers\Controller;
use App\Models\Font;
use App\Services\Font\FontService;
use Illuminate\Http\Request;

class FontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fonts = Font::orderbydesc('id')->get();
        return view('backend.pages.font.index',compact('fonts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        dd('font create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        FontService::fontCreate(filterRequest());
        return redirect()->back()->with(['success' => "Font Created successfully"]);
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
        FontService::fontUpdate(filterRequest(), $id);
        return redirect()->back()->with(['success' => "Font Update successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Font::where('id', $id)->delete();
        return redirect()->back()->with(['success' => "Font Delete successfully"]);
    }
}
