<?php

namespace App\Http\Controllers;

use App\Models\SsrReport;
use App\Models\UploadSsr;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UploadSsrController extends Controller
{
    public function show()
    {
        return view(request('view'));
    }

    public function upload()
    {
        $mimes = 'csv,txt';
        $expected_columns = 11;
        $first_column = 'department';

        request()->validate([
            'file' => 'required|mimes:' . $mimes,
        ]);

        $path = request()->file('file')->getRealPath();
        $data = array_map('str_getcsv', file($path));

        try {
            $columns = sizeof($data[0]);
        } catch (\Throwable $th) {
            $columns = 0;
        }

        if ($columns != $expected_columns) {
            $error = 'Wrong SSR file format. File should have ' . $expected_columns . ' columns. ' . $columns . ' columns found.';

            UploadSsr::create([
                'user_id' => auth()->id(),
                'description' => $error
            ]);
            throw ValidationException::withMessages([$error]);
        }

        try {
            \DB::beginTransaction();
            SsrReport::whereRaw(true)->delete();

            foreach ($data as $row) {
                if (strtolower($row[0]) != $first_column) {
                    $i = 0;

                    SsrReport::create([
                        'department' => $row[$i++],
                        'condition' => $row[$i++],
                        'supplier' => $row[$i++],
                        'item_code' => $row[$i++],
                        'description' => $row[$i++],
                        'category' => $row[$i++],
                        'uom' => $row[$i++],
                        'center' => str_replace(',', '', $row[$i++]),
                        'north' => str_replace(',', '', $row[$i++]),
                        'south' => str_replace(',', '', $row[$i++]),
                        'total' => str_replace(',', '', $row[$i++]),
                    ]);
                }
            }

            UploadSsr::create([
                'user_id' => auth()->id(),
                'description' => 'success'
            ]);
            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollback();

            UploadSsr::create([
                'user_id' => auth()->id(),
                'description' => $th->getMessage()
            ]);
            throw ValidationException::withMessages(['Could not import the file'], [$th->getMessage()]);
        }

        session()->flash('success', 'Success');
        return view(request('view'));
    }
}
