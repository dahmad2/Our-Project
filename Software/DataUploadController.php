<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DataUploadController extends Controller
{
    public function showUploadForm()
    {
        return view('admin.upload');
    }

    public function handleUpload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $file = fopen($path, 'r');

        $header = fgetcsv($file);

        while ($row = fgetcsv($file)) {
            $data = array_combine($header, $row);

            DB::table('postcodes')->insert([
                'Postcode' => $data['Postcode'] ?? null,
                'PostcodeNS' => $data['PostcodeNS'] ?? null,
                'LSOA11' => $data['LSOA11'] ?? null,
                'MSOA11' => $data['MSOA11'] ?? null,
                'WardCodeONSNSPL' => $data['WardCodeONSNSPL'] ?? null,
                'WardNameONSNSPL' => $data['WardNameONSNSPL'] ?? null,
                'ConstituencyCodeONSNSPL' => $data['ConstituencyCodeONSNSPL'] ?? null,
                'ConstituencyNameONSNSPL' => $data['ConstituencyNameONSNSPL'] ?? null,
                'CCG' => $data['CCG'] ?? null,
                'WardCodeCurrent' => $data['WardCodeCurrent'] ?? null,
                'WardNameCurrent' => $data['WardNameCurrent'] ?? null,
                'ConstituencyCodeCurrent' => $data['ConstituencyCodeCurrent'] ?? null,
                'ConstituencyNameCurrent' => $data['ConstituencyNameCurrent'] ?? null,
                'Latitude' => $data['Latitude'] ?? null,
                'Longitude' => $data['Longitude'] ?? null,
                'DateOfTermination' => $data['DateOfTermination'] ?? null,
            ]);
        }

        fclose($file);

        return back()->with('success', 'CSV Uploaded and Data Imported Successfully.');
    }
}
