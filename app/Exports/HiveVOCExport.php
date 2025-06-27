<?php

namespace App\Exports;

use App\Models\HiveVOC;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HiveVOCExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Return all VOC records (you can filter by hive_id if needed)
        return HiveVOC::all();
    }

    /**
     * Define the headings for the Excel sheet.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Record',
            'Hive ID',
            'Created At',
            'Updated At',
        ];
    }
}
