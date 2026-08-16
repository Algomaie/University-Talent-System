<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ParticipantsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $participants;

    public function __construct($participants)
    {
        $this->participants = $participants;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->participants;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Phone',
            'University',
            'Major',
            'Total Submissions',
            'Registered At',
        ];
    }

    /**
     * @param mixed $participant
     * @return array
     */
    public function map($participant): array
    {
        return [
            $participant->id,
            $participant->name,
            $participant->email,
            $participant->phone ?? '',
            $participant->university ?? '',
            $participant->major ?? '',
            $participant->submissions_count ?? 0,
            $participant->created_at ? $participant->created_at->format('Y-m-d H:i:s') : '',
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