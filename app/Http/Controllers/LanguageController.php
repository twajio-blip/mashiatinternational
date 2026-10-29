<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\Translation;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = Language::latest()->paginate(15);
        return view('backend.language.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.language.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'is_rtl' => 'required',
        ]);

        $language  = new Language();
        $language->name = $request->name;
        $language->code = $request->code;
        $language->is_rtl = $request->is_rtl;
        $language->save();
        return redirect()->route('backend.language.index')->with('success', 'Data inserted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $data['sort_search'] = null;
        $data['language'] = Language::findOrFail($id);
        $translations = Translation::where('language', 'en');
        if ($request->has('language_key_search')) {
            $data['sort_search'] = $request->language_key_search;
            $translations = $translations->where('translation_key', 'like', '%' . $request->language_key_search . '%');
        }
        $data['translations'] = $translations->latest()->paginate(20);
        return view('backend.language.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $language = Language::find($id);
        return view('backend.language.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $language = Language::find($id);

        if (! $language) {
            return back()->with('error', 'Something went wrong, please try again');
        }

        $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'is_rtl' => 'required',
        ]);

        $language->name = $request->name;
        $language->code = $request->code;
        $language->is_rtl = $request->is_rtl;
        $language->save();
        return redirect()->route('admin.language.index')->with('success', 'Data updated successfully!');
    }

    public function store_language_key_value(Request $request)
    {
        $language = Language::findOrFail($request->language_id);
        foreach ($request->translations as $key => $value) {
            $translation = Translation::where('translation_key', $key)->where('language', $language->code)->latest()->first();
            if ($translation == null) {
                $translation = new Translation;
                $translation->language = $language->code;
                $translation->translation_key = $key;
                $translation->translation_value = $value;
                $translation->save();
            } else {
                $translation->translation_value = $value;
                $translation->save();
            }
        }
        clear_cache();
        return back()->with('success','Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $language = Language::find($id);
        $language->delete();
        return redirect()->route('admin.language.index')->with('success', 'Data deleted successfully!');
    }

    public function change_status(Request $request)
    {
        $language = Language::findOrFail($request->id);
        $language->status = $request->status;
        $language->save();
        return 1;
    }
    public function switch_language(Request $request)
    {
        $request->session()->put('locale', $request->language_code);
        App::setLocale($request->language_code);
        $language = Language::where('code', $request->language_code)->first();
        toastr()->addSuccess(translation('Language changed to  ').' '. $language->name);
    }
}
