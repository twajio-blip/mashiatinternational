<?php

namespace App\Http\Controllers\Backend\Pages;

use DOMXPath;
use DOMDocument;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\ComponentMaster;
use DiffMatchPatch\DiffMatchPatch;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Pages\PagesService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use App\Services\ReplaceVersion\HtmlMergeService;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::orderByDesc('id')->whereNot('status', 3)->get();
        return view('backend.pages.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $components = ComponentMaster::with('componentFiled')
            ->orderByRaw('SUBSTRING(name, 1, 1) ASC') // Sort by the first letter of 'name' field
            ->get();

        return view('backend.pages.pages.create', compact('components'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        PagesService::create(filterRequest());
        if ($request->has('save')) {
            return redirect()->back()->with('success', 'Page created successfully');
        }
        if ($request->has('preview')) {
            return redirect()->to(url($request->permalink));
        }

        return redirect()->route('pages.index')->with('success', 'Page created successfully');
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

  
        $components = ComponentMaster::with(['componentFiled', 'pageStatus' => function ($query) use ($id) {
            $query->where('page_id', $id);
        }, 'componentFiledPageWise' => function ($query) use ($id) {
            $query->where('page_id', $id);
        }])
            ->orderByRaw('SUBSTRING(name, 1, 1) ASC')
            ->get();


        $page = Page::where('id', $id)->with('component')->first();
        // if ($page->component[0]->set_from == 'database') {
        //     $dataBaseData = DB::table($page->component[0]->database)->limit(1)->get();
        // } else {
        //     $dataBaseData = [];
        // }
        // // Get column data types
        // $columnTypes = array_combine($columns = Schema::getColumnListing($page->component[0]->database), array_map(fn($column) => DB::getSchemaBuilder()->getColumnType($page->component[0]->database, $column), $columns));
        // $components->getDataBase = ['data' =>$dataBaseData,'type' =>$columnTypes];
        return view('backend.pages.pages.edit', compact('components', 'page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
    

        PagesService::Update(filterRequest(), $id);

        if ($request->has('save')) {
            return redirect()->back()->with('success', 'Page Update successfully');
        }
        if ($request->has('preview')) {
            return redirect()->to(url($request->permalink));
        }

        return redirect()->route('pages.index')->with('success', 'Page Update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page =   Page::where('id', $id)->first();
        if ($page->image) {
            unlink('images/' . $page->image);
        }
        $page->delete();
        return redirect()->back()->with('success', 'Page Delete successfully');
    }


    public function addui()
    {
        $componentId = request()->input('id') ?? request()->input('component_id');
        if (is_array($componentId)) {
            $componentId = $componentId[0] ?? null;
        }
        $componentId = $componentId ? (int) $componentId : null;
        if (!$componentId) {
            return response()->json(['error' => 'Component ID is required'], 422);
        }

        PagesService::PagesUI(request()->all());

        $info = ComponentMaster::find($componentId);
        if (!$info) {
            return response()->json(['error' => 'Component not found'], 404);
        }

        $pageId = request()->page_id_for_status ?? request()->page_id;
        $display = request()->display ?? 1;
        $additem = ['id' => $info->id, 'name' => $info->name, 'display' => $display];

        $components = ComponentMaster::orderByDesc('id')->with(['componentFiled', 'pageStatus' => function ($query) {
            $query->where('page_id', request()->page_id_for_status);
        }, 'componentFiledPageWise' => function ($query) {
            $query->where('page_id', request()->page_id_for_status);
        }])->get();

        return response()->json(['component' => $components, 'item' => $additem]);
    }

    public function loadComponent()
    {

        $component  = ComponentMaster::where('name', request()->data)->with('componentFiled', 'limits')->get();
        $elements = $component->flatMap(function ($component) {
            return [
                $component->name => $component->componentFiled->map(function ($field) {
                    $group = $field->group ? $field->group  : 0;
                    return [$group => [
                        $field->name => $field->value,
                    ]];
                })
            ];
        });
        $components = [];
        foreach ($elements as $parent => $value) {
            $group = [];
            foreach ($value as $child) {
                $firstKey = key($child);
                $name = key($child[$firstKey]);
                if ($firstKey == 2) {
                    break;
                }
                $group[$firstKey][$name] = current($child[$firstKey]);
            }

            $components[$parent] = $group;
        }
        foreach ($component as $data) {
            $db_name = $data->database;
            if ($db_name && $data->set_from == 'database') {
                if (count($components[$data->name]) == 0) {
                    $components[$data->name][0] = [];
                }

                $components[$data->name][1] = DB::table($db_name)->limit(1)->get()->toArray();
            }
        }

        return view('backend.LoadComponent', compact('components'));
    }


    public function loadComponentStore()
    {


        // Get the new HTML content from the request
        $newHtml = request()->data;
        $newHtml = trim($newHtml); // Trim whitespace
        $newHtml = preg_replace('/\s+/', ' ', $newHtml);
        $newHtml = preg_replace('/>\s+</', '> <', $newHtml);
        // Define the path to the Blade component file
        $filePath = base_path('resources/views/components/frontend/' . request()->component . '.blade.php');

        // Get the current (old) HTML content from the Blade component
        $oldHtml = File::get($filePath);
        $oldHtml = trim($oldHtml); // Trim whitespace
        $oldHtml = preg_replace('/\s+/', ' ', $oldHtml);
        // Optional: Remove extra spaces between tags
        $oldHtml = preg_replace('/>\s+</', '> <', $oldHtml);


        // Extract classes and styles from both old and new HTML
        $oldChanges = $this->extractClassesAndStyles($oldHtml);
        $newChanges = $this->extractClassesAndStyles($newHtml);


        foreach ($oldChanges as $tag => $item) {


            foreach ($item as $key => $oldAttributes) {
                // Get the new attributes for the current tag
                if (isset($newChanges[$tag][$key])) {


                    $newAttributes = $newChanges[$tag][$key];
                    $escapedClasses =  preg_quote($oldAttributes['class'], '/');
                    // Manage class changes
                    if (isset($newAttributes['class']) && $oldAttributes['class'] !== $newAttributes['class']) {
                        // Regex to find the class attribute within the matching tag


                        // Regex pattern to find the specified tag with the class attribute
                        $patternClass = "/(<\s*{$tag}[^>]*?)\bclass\s*=\s*['\"][^'\"]*{$escapedClasses}[^'\"]*['\"]([^>]*>)/i";

                        if (preg_match($patternClass, $oldHtml)) {
                            // If class exists, replace it with the new class
                            $replacement = "$1 class=\"{$newAttributes['class']}\" $2";
                            $oldHtml = preg_replace($patternClass, $replacement, $oldHtml);
                        } else {
                            // If no class exists, add the class attribute to the tag
                            $patternAddClass = "/(<{$tag}[^>]*?)(\s?\/?>)/i"; // Handle self-closing tags
                            $replacement = "$1 class=\"{$newAttributes['class']}\"$2";
                            $oldHtml = preg_replace($patternAddClass, $replacement, $oldHtml);
                        }
                    }


                    if (isset($newAttributes['style'])) {
                        // Escape special characters for use in the regular expression
                        $escapedClasses = preg_quote($oldAttributes['class'], '/');

                        // Pattern to find the tag with the desired class and replace the style attribute (if it exists)
                        $patternStyle = "/(<\s*{$tag}[^>]*?\bclass\s*=\s*['\"][^'\"]*{$escapedClasses}[^'\"]*['\"][^>]*?)\bstyle\s*=\s*['\"][^'\"]*['\"]([^>]*>)/i";

                        if (preg_match($patternStyle, $oldHtml)) {
                            // If the style attribute already exists, replace just the style while keeping the rest of the tag intact
                            $replacement = "$1 style=\"{$newAttributes['style']}\" $2";
                            $oldHtml = preg_replace($patternStyle, $replacement, $oldHtml);
                        } else {
                            // Pattern to find the tag with the desired class but no style attribute, so we add it without touching other attributes
                            $patternAddStyle = "/(<\s*{$tag}[^>]*?\bclass\s*=\s*['\"][^'\"]*{$escapedClasses}[^'\"]*['\"][^>]*?)(\s?\/?>)/i";
                            $replacement = "$1 style=\"{$newAttributes['style']}\"$2";
                            $oldHtml = preg_replace($patternAddStyle, $replacement, $oldHtml);
                        }
                    }
                }
            }
        }




        // Save the updated HTML back to the Blade component file
        File::put($filePath, $oldHtml);
    }

    function extractClassesAndStyles($html)
    {
        $dom = new \DOMDocument();

        // Suppress warnings for malformed HTML
        @$dom->loadHTML($html);

        $xpath = new \DOMXPath($dom);

        // Get all elements
        $elements = $xpath->query('//*'); // Select all elements
        $changes = []; // Initialize the array to store classes and styles

        foreach ($elements as $element) {
            $class = $element->getAttribute('class');
            $style = $element->getAttribute('style');

            // Get the tag name
            $tagName = $element->nodeName;

            // Check if class or style exists, if so, add them
            if ($class || $style) {
                // If tag is not set in changes, initialize it
                if (!isset($changes[$tagName])) {
                    $changes[$tagName] = [];
                }

                // Add classes and styles to the specific tag
                $changes[$tagName][] = [
                    'class' => $class ? trim($class) : null,
                    'style' => $style ? trim($style) : null
                ];
            }
        }

        return $changes; // Return the array of changes
    }
}
