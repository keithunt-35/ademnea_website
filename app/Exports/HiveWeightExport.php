<?php

namespace App\Exports;

use App\Models\HiveWeight;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HiveWeightExport implements FromCollection,WithHeadings
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
        return HiveWeight::where('hive_id', $this->hiveId)
            ->latest()
            ->limit(100)
            ->get(['record', 'created_at']);
    }

    /**
     * Set the headings for the Excel sheet.
     */
    public function headings(): array
    {
        return [
            'Weight (kg)',
            'Date',
        ];
    } 
}
