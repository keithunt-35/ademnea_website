<?php

namespace App\Exports;

use App\Models\HiveHumidity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HiveHumidityExport implements FromCollection,WithHeadings
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
        return HiveHumidity::where('hive_id', $this->hiveId)
            ->latest()
            ->limit(100)
            ->get()
            ->map(function ($item) {
                $recordParts = explode('*', $item->record);
                return [
                    'interior' => $recordParts[0] ?? null,
                    'exterior' => $recordParts[2] ?? null,
                    'created_at' => $item->created_at,
                ];
            });
    }

    /**
     * Set the headings for the Excel sheet.
     */
    public function headings(): array
    {
        return [
            'Interior (%)',
            'Exterior (%)',
            'Date',
        ];
    }
}
