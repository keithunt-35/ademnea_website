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

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Record',
            'Hive ID',
            'Created At',
        ];
    }

    public function map($temperature): array
    {
        return [
            $temperature->id,
            $temperature->hive_id,
            explode('*', $temperature->record)[0],
            explode('*', $temperature->record)[2],
            $temperature->created_at,
        ];
    }
}
