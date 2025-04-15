<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;

class AssetController extends Controller
{
    public function index()
{
    $assets = Asset::paginate(10); // instead of ->get()

    return view('admin.assets.index', compact('assets'));
}

    public function create()
    {
        return view('admin.assets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'postcode' => 'required|string|max:255',
            'postcode_ns' => 'nullable|string|max:255',
            'lsoa11' => 'nullable|string|max:255',
            'msoa11' => 'nullable|string|max:255',
            'ward_code_ons' => 'nullable|string|max:255',
            'ward_name_ons' => 'nullable|string|max:255',
            'constituency_code_ons' => 'nullable|string|max:255',
            'constituency_name_ons' => 'nullable|string|max:255',
            'ccg' => 'nullable|string|max:255',
            'ward_code_current' => 'nullable|string|max:255',
            'ward_name_current' => 'nullable|string|max:255',
            'constituency_code_current' => 'nullable|string|max:255',
            'constituency_name_current' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'date_of_termination' => 'nullable|date',
        ]);

        Asset::create($validated);

        return redirect()->route('admin.assets.index')->with('success', 'Asset created successfully.');
    }

    public function edit(Asset $asset)
    {
        return view('admin.assets.edit', compact('asset'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'postcode' => 'required|string|max:255',
            'postcode_ns' => 'nullable|string|max:255',
            'lsoa11' => 'nullable|string|max:255',
            'msoa11' => 'nullable|string|max:255',
            'ward_code_ons' => 'nullable|string|max:255',
            'ward_name_ons' => 'nullable|string|max:255',
            'constituency_code_ons' => 'nullable|string|max:255',
            'constituency_name_ons' => 'nullable|string|max:255',
            'ccg' => 'nullable|string|max:255',
            'ward_code_current' => 'nullable|string|max:255',
            'ward_name_current' => 'nullable|string|max:255',
            'constituency_code_current' => 'nullable|string|max:255',
            'constituency_name_current' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'date_of_termination' => 'nullable|date',
        ]);

        $asset->update($validated);

        return redirect()->route('admin.assets.index')->with('success', 'Asset updated successfully.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('admin.assets.index')->with('success', 'Asset deleted successfully.');
    }

    public function showUploadForm()
    {
        return view('admin.upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:5120',
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $file = fopen($path, 'r');
        $header = fgetcsv($file);
        $rows = 0;

        while ($row = fgetcsv($file)) {
            $rows++;
            Asset::create([
                'postcode' => $row[0] ?? null,
                'postcode_ns' => $row[1] ?? null,
                'lsoa11' => $row[2] ?? null,
                'msoa11' => $row[3] ?? null,
                'ward_code_ons' => $row[4] ?? null,
                'ward_name_ons' => $row[5] ?? null,
                'constituency_code_ons' => $row[6] ?? null,
                'constituency_name_ons' => $row[7] ?? null,
                'ccg' => $row[8] ?? null,
                'ward_code_current' => $row[9] ?? null,
                'ward_name_current' => $row[10] ?? null,
                'constituency_code_current' => $row[11] ?? null,
                'constituency_name_current' => $row[12] ?? null,
                'latitude' => $row[13] ?? null,
                'longitude' => $row[14] ?? null,
                'date_of_termination' => $row[15] ?? null,
            ]);
        }

        fclose($file);
        return back()->with('success', "Successfully uploaded {$rows} records!");
    }

    public function map()
    {
        $assets = Asset::select('postcode', 'latitude', 'longitude', 'ward_name_current')->whereNotNull('latitude')->get();
        $departments = Asset::select('department')->distinct()->pluck('department');
        $wards = Asset::select('ward_name_current')->distinct()->pluck('ward_name_current');
        return view('admin.map', compact('assets', 'departments', 'wards'));
    }

    public function departments()
    {
        $departments = Asset::select('department')->distinct()->pluck('department');
        return view('admin.departments', compact('departments'));
    }
}
