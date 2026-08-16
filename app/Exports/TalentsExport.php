<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TalentsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $talents;

    public function __construct($talents)
    {
        $this->talents = $talents;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->talents;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name (Arabic)',
            'Name (English)',
            'Description (Arabic)',
            'Description (English)',
            'Status',
            'Total Submissions',
            'Created At',
        ];
    }

    /**
     * @param mixed $talent
     * @return array
     */
    public function map($talent): array
    {
        return [
            $talent->id,
            $talent->name_ar,
            $talent->name_en,
            $talent->description_ar ?? '',
            $talent->description_en ?? '',
            ucfirst($talent->status),
            $talent->submissions_count ?? 0,
            $talent->created_at ? $talent->created_at->format('Y-m-d H:i:s') : '',
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}