<?php

namespace App\Http\Controllers\Backend\Slider;

use App\Http\Controllers\Controller;
use App\Http\Requests\Slider\SlideStoreRequest;
use App\Http\Requests\Slider\SlideUpdateRequest;
use App\Models\Slider;
use App\Services\Slider\SliderService;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::orderbydesc('id')->paginate(10);
        return view('backend.pages.sliders.index', compact('sliders'));
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
    public function store(SlideStoreRequest $request)
    {
        SliderService::sliderCreate(request()->only('content', 'btn_name', "btn_url", 'image'));
        return redirect()->back()->with(['success' => "Slide create successfully"]);
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
    public function update(SlideUpdateRequest $request, string $id)
    {
        SliderService::sliderUpdate(request()->only('content', 'btn_name', "btn_url", 'image'), $id);
        return redirect()->back()->with(['success' => "Slide Update successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slide = Slider::where('id', $id)->first();
        if ($slide->image) {
            unlink('images/' . $slide->image);
        }
        $slide->delete();
        return redirect()->back()->with(['success' => "Slide Delete successfully"]);
    }
}