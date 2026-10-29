<?php

namespace App\Http\Controllers\Backend\Widget;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\widget;
use App\Services\Widget\WidgetService;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Widget::whereNull('parent_id')->orderBy('position');
        $widgets =  Widget::with('children')->whereNull('parent_id')->orderBy('position')->get();


        $pages = Page::whereNotIn('id', Widget::whereNotNull('ref_id')->pluck('ref_id'))->get(['id', 'name', 'permalink']);

        return view('backend.pages.widget.index', compact('pages', 'widgets'));
    }

    function loadChildrenRecursively($query, $depth = 5)
    {
        if ($depth <= 0) return $query;

        return $query->with([
            'children' => function ($q) use ($depth) {
                $this->loadChildrenRecursively($q, $depth - 1);
            }
        ]);
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

        WidgetService::update(request()->all());
        return redirect()->back()->with(['success' => "Route update successfully"]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
