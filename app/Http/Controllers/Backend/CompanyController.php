<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CompanyStoreRequest;
use App\Models\Company;
use App\Services\Company\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companys = Company::orderByDesc('id')->paginate(10);
        return view('backend.pages.company.index', compact('companys'));
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
    public function store(CompanyStoreRequest $request)
    {
        CompanyService::Create(filterRequest());
        return redirect()->back()->with(['success' => "Company create successfully"]);
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
        CompanyService::update(filterRequest(), $id);
        return redirect()->back()->with(['success' => "Company update successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::where('id', $id)->first();
        if ($company->image) {
            unlink('images/' . $company->image);
        }
        $company->delete();
        return redirect()->back()->with(['success' => "Company Delete successfully"]);
    }
}