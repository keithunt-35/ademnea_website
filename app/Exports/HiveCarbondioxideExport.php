<?php

namespace App\Exports;
use App\Models\HiveCarbondioxide;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HiveCarbondioxideExport implements FromCollection,WithHeadings
{
    protected $hiveId;

    public function __construct($hiveId)
    {
        $this->hiveId = $hiveId;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return HiveCarbondioxide::where('hive_id', $this->hiveId)
            ->latest()
            ->limit(100)
            ->get(['record', 'created_at']);
    }

    //Excel headings
    public function headings(): array
    {
        return [
            'CO2 (ppm)',
            'Date',
        ];
    }
}
