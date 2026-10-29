<?php

namespace App\Http\Controllers\Backend\Faq;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Services\Faq\FaqService;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = Faq::orderbydesc('id')->paginate(10);
        return view('backend.pages.faq.index',  compact('faqs'));
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
        FaqService::faqCreate(request()->except('_token', 'proengsoft_jsvalidation'));
        return redirect()->back()->with(['success' => "Faq Create successfully"]);
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        FaqService::faqUpdate(request()->except('_token', 'proengsoft_jsvalidation', 'method'), $id);
        return redirect()->back()->with(['success' => "Faq Update successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Faq = Faq::where('id', $id)->delete();
        return redirect()->back()->with(['success' => "Faq Delete successfully"]);
    }
}
