<?php

namespace App\Exports;

use App\Models\EnergySale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EnergySalesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $year;
    protected $month;
    protected $powerPlantId;

    public function __construct($year, $month, $powerPlantId = null)
    {
        $this->year         = $year;
        $this->month        = $month;
        $this->powerPlantId = $powerPlantId;
    }

    public function collection()
    {
        $query = EnergySale::with(['powerPlant', 'organization'])
            ->when($this->year, fn($q) => $q->where('year', $this->year))
            ->when($this->month, fn($q) => $q->where('month', $this->month))
            ->when($this->powerPlantId, fn($q) => $q->where('power_plant_id', $this->powerPlantId));

        return $query->get();
    }

    public function headings(): array
    {
        return [
            '#', 'Байгууллага', 'Станц', 'Он', 'Сар', 'Бүтээгдэхүүн', 'Нэгж',
            'Өмнөх сар', 'Тайлант сар', 'Өөрийн хэрэглээ', 'Жилийн эхнээс',
        ];
    }

    public function map($row): array
    {
        static $i = 0;
        $i++;
        return [
            $i,
            $row->organization?->org_name ?? '—',
            $row->powerPlant->plant_name,
            $row->year,
            $row->month,
            $row->product_name,
            $row->unit_name,
            $row->before_month,
            $row->this_month,
            $row->year_usage,
            $row->this_musage,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}
