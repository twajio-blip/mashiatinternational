<?php

namespace App\Http\Controllers\Backend\Component;

use App\Http\Controllers\Controller;
use App\Http\Requests\Component\ComponentCreateRequest;
use App\Http\Controllers\Backend\Pages\DynamicComponentController;
use App\Models\ComponentField;
use App\Models\ComponentMaster;
use App\Services\Component\ComponentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $components = ComponentMaster::orderBy('position', 'asc')
            ->orderBy('id', 'asc')
            ->with('componentFiled')
            ->get();
        $manageableComponents = DynamicComponentController::getManageableComponents();

        // Also pass all components for \"connect\" dropdowns (id => name)
        $allComponents = ComponentMaster::orderBy('name')->pluck('name', 'id');

        return view('backend.pages.component.index', compact('components', 'manageableComponents', 'allComponents'));
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
    public function store(ComponentCreateRequest $request)
    {
        ComponentService::ComponentCreate(request()->all());
        Cache::forget('dynamic_sidebar_components');
        Artisan::call('cache:clear');
        return redirect()->back()->with(['success' => "Component create successfully"]);
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
        ComponentService::ComponentUpdate(request()->all(), $id);
        Cache::forget('dynamic_sidebar_components');
        Artisan::call('cache:clear');
        return redirect()->back()->with(['success' => "Component Update successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ComponentMaster::where('id', $id)->delete();
        Cache::forget('dynamic_sidebar_components');
        Artisan::call('cache:clear');
        return redirect()->back()->with(['success' => "Component Delete successfully"]);
    }
    public function fieldDelete()
    {

        $component = ComponentField::where('id', request()->id)->first();

        $component =  ComponentField::where('component_id',$component->component_id)->where('name',$component->name)->delete();

        $component->delete();

        return response()->json(true);
    }

    /**
     * Reorder components (move up/down)
     */
    public function reorder(Request $request)
    {
        $id = (int) $request->input('id');
        $direction = $request->input('direction'); // 'up' or 'down'

        $components = ComponentMaster::orderBy('position', 'asc')->orderBy('id', 'asc')->get();
        $index = $components->search(fn($c) => $c->id == $id);
        if ($index === false) {
            return response()->json(['success' => false], 404);
        }

        $newIndex = $direction === 'up' ? $index - 1 : $index + 1;
        if ($newIndex < 0 || $newIndex >= $components->count()) {
            return response()->json(['success' => true]);
        }

        $items = $components->values()->all();
        $temp = $items[$index];
        $items[$index] = $items[$newIndex];
        $items[$newIndex] = $temp;

        foreach ($items as $pos => $comp) {
            $comp->update(['position' => $pos + 1]);
        }

        Cache::forget('dynamic_sidebar_components');
        Artisan::call('cache:clear');
        return response()->json(['success' => true]);
    }

    /**
     * Build SQL export string for a component.
     */
    protected function buildSqlForComponent(ComponentMaster $component): string
    {
        $lines = [];
        $lines[] = '-- Export for component: ' . $component->name;
        $lines[] = '-- Generated at: ' . now()->toDateTimeString();
        $lines[] = '';

        // Export component_masters row
        if (Schema::hasTable('component_masters')) {
            $cols = Schema::getColumnListing('component_masters');
            $row = DB::table('component_masters')->where('id', $component->id)->first();
            if ($row) {
                $values = [];
                foreach ($cols as $col) {
                    $values[] = $this->toSqlValue($row->{$col} ?? null);
                }
                $lines[] = '-- Component master definition';
                $lines[] = 'INSERT INTO `component_masters` (`' . implode('`,`', $cols) . '`) VALUES (' . implode(',', $values) . ');';
                $lines[] = '';
            }
        }

        // Export component_fields rows for this component
        if (Schema::hasTable('component_fields')) {
            $cols = Schema::getColumnListing('component_fields');
            $rows = DB::table('component_fields')->where('component_id', $component->id)->orderBy('id')->get();
            if ($rows->count()) {
                $lines[] = '-- Component fields';
                foreach ($rows as $r) {
                    $values = [];
                    foreach ($cols as $col) {
                        $values[] = $this->toSqlValue($r->{$col} ?? null);
                    }
                    $lines[] = 'INSERT INTO `component_fields` (`' . implode('`,`', $cols) . '`) VALUES (' . implode(',', $values) . ');';
                }
                $lines[] = '';
            }
        }

        // Export external database table if this component pulls from a table
        if ($component->set_from === 'database' && $component->database && Schema::hasTable($component->database)) {
            $tableName = $component->database;
            $cols = Schema::getColumnListing($tableName);
            $rows = DB::table($tableName)->orderBy('id')->get();
            if ($rows->count()) {
                $lines[] = '-- External table data: ' . $tableName;
                foreach ($rows as $r) {
                    $values = [];
                    foreach ($cols as $col) {
                        $values[] = $this->toSqlValue($r->{$col} ?? null);
                    }
                    $lines[] = 'INSERT INTO `' . $tableName . '` (`' . implode('`,`', $cols) . '`) VALUES (' . implode(',', $values) . ');';
                }
                $lines[] = '';
            }
        }

        $sql = implode("\n", $lines) . "\n";
        return $sql;
    }

    /**
     * Export component-related data as SQL file (download).
     */
    public function exportSql(string $id)
    {
        $component = ComponentMaster::with('componentFiled')->findOrFail($id);
        $sql = $this->buildSqlForComponent($component);
        $filename = 'component_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $component->name) . '_export.sql';

        return response($sql)
            ->header('Content-Type', 'application/sql')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

    /**
     * Show component-related SQL in browser (no download).
     */
    public function exportSqlView(string $id)
    {
        $component = ComponentMaster::with('componentFiled')->findOrFail($id);
        $sql = $this->buildSqlForComponent($component);

        return response($sql)
            ->header('Content-Type', 'text/plain; charset=utf-8');
    }

    /**
     * Simple SQL value escaper for export.
     *
     * @param mixed $value
     */
    protected function toSqlValue($value): string
    {
        if ($value === null) {
            return 'NULL';
        }
        if (is_bool($value)) {
            return $value ? '1' : '0';
        }
        if (is_int($value) || is_float($value)) {
            return (string) $value;
        }
        // escape single quotes
        $str = (string) $value;
        $str = str_replace(["\\", "'"], ["\\\\", "''"], $str);
        return "'" . $str . "'";
    }
}
