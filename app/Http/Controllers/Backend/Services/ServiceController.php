<?php

namespace App\Http\Controllers\Backend\Services;

use App\Http\Controllers\Controller;
use App\Models\Services;
use App\Services\Services\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Services::orderbyDesc('id')->paginate(10);
        return view('backend.pages.services.index',  compact('services'));
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
        ServiceService::ServicesCreate(request()->except("_token", 'proengsoft_jsvalidation'));
        return redirect()->back()->with(['success' => "Services create successfully"]);
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
        ServiceService::ServicesUpdate(request()->except("_token", 'proengsoft_jsvalidation', 'method'), $id);
        return redirect()->back()->with(['success' => "Services Update successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Services::where('id', $id)->first();
        if ($service->image) {
            unlink('images/' . $service->image);
        }
        $service->delete();
        return redirect()->back()->with(['success' => "Service Delete successfully"]);
    }
}
