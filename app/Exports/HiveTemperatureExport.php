<?php

namespace App\Exports;

use App\Models\HiveTemperature;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HiveTemperatureExport implements FromCollection, WithHeadings, WithMapping
{
    protected $fromDate;
    protected $toDate;
    protected $hiveId;

    public function __construct($fromDate, $toDate, $hiveId)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->hiveId = $hiveId;
    }

    public function collection()
    {
        $query = HiveTemperature::query();

        if ($this->fromDate && $this->toDate) {
            $query->whereBetween('created_at', [$this->fromDate, $this->toDate]);
        }

        if ($this->hiveId) {
            $query->where('hive_id', $this->hiveId);
        }

        $data = $query->get();

        // \Log::info('Export query data:', $data->toArray());

        return $data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Hive ID',
            'Interior Temperature(°C)',
            'Exterior Temperature (°C)',
            'Created At',
        ];
    }

    public function map($temperature): array
    {
        $recordParts = explode('*', $temperature->record);
        return [
            $temperature->id,
            $temperature->hive_id,
            $recordParts[0] ?? 'N/A', // Interior Temperature
            $recordParts[2] ?? 'N/A', // Exterior Temperature
            $temperature->created_at,
        ];
    }
}
