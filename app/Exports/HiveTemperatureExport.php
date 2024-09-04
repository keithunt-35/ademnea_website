<?php



namespace App\Exports;

use App\Models\HiveTemperature;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HiveTemperatureExport implements FromCollection, WithHeadings
{
    
    protected $hiveId;

    public function __construct($hiveId)
    {
       
         $this->hiveId = $hiveId;
    }

    public function collection()

    {
        // return HiveTemperature::all();
        // return collect([
        //     (object) ['id'=>1, 'record'=>'20*23*25', 'created_at' => now()],
        //     (object) ['id'=>2, 'record'=>'22*24*26', 'created_at' => now()],
        // ]);

        return HiveTemperature::where('hive_id', $this->hiveId)
            ->latest()
            ->get()
            ->map(function ($temperature) {
                $recordParts = explode('*', $temperature->record);
                return [
                    
                    'interior' => $recordParts[0] ?? null,
                    'exterior' => $recordParts[2] ?? null,
                    'created_at' => $temperature->created_at,
                ];
            });

            
    }

    public function headings(): array
    {
        return [
            'Interior (°C)',
            'Exterior (°C)',
            'Date',
        ];
    }
    //  public function map($temperature): array

    //  {
    //     $recordParts = explode('*', $temperature->record);
    //     return [
    //         'id',
    //         'interior' => $recordParts[0] ?? null,
    //         'exterior' => $recordParts[2] ?? null,
    //         'created_at' => $temperature->created_at,
    //     ];
    //     // \Log::info('Mapping temperature: ' . json_encode($temperature));
    //     
    //}

    
}
