<?php

namespace App\Http\Controllers;

use App\Models\Config;
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
        $config_columns = Config::getItem('ssr_columns_sequence');

        $mimes = 'csv,txt';
        $expected_columns = sizeof($config_columns);
        $first_column = $config_columns[0];
        $number_cols = [
            'center',
            'north',
            'south',
            'huawei',
            'zte',
            'ericsson',
        ];

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

        if (strtolower($data[0][0]) != $first_column) {
            $error = 'Wrong SSR file format. First column of first row should be ' . $first_column;

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
                    foreach ($config_columns as $col) {
                        if (in_array($col, $number_cols)) {
                            $create[$col] = str_replace(',', '', $row[$i++]);
                        } else {
                            $create[$col] = $row[$i++];
                        }
                    }

                    SsrReport::create($create);
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
