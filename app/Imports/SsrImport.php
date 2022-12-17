<?php

namespace App\Imports;

use App\Models\SsrReport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SsrImport implements ToModel, WithStartRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (sizeof($row) > 11) {
            dd($row);
        }

        if ($row[3] == 25050014) {
            // dd($row);
        }

        $i = 0;
        return new SsrReport([
            'department' => $row[$i++],
            'condition' => $row[$i++],
            'supplier' => $row[$i++],
            'item_code' => $row[$i++],
            'description' => $row[$i++],
            'category' => $row[$i++],
            'uom' => $row[$i++],
            'center' => $row[$i++],
            'north' => $row[$i++],
            'south' => $row[$i++],
            'total' => $row[$i++],
        ]);
    }
}
