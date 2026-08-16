<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubmissionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $submissions;

    public function __construct($submissions)
    {
        $this->submissions = $submissions;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->submissions;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Student Name',
            'Competition',
            'Talent Category',
            'Title',
            'Status',
            'Submitted At',
            'Average Score',
        ];
    }

    /**
     * @param mixed $submission
     * @return array
     */
    public function map($submission): array
    {
        return [
            $submission->id,
            $submission->user->name ?? '',
            $submission->competition->title ?? '',
            $submission->talent->name ?? '',
            $submission->title,
            ucfirst($submission->status),
            $submission->submitted_at ? $submission->submitted_at->format('Y-m-d H:i:s') : '',
            $submission->evaluations->avg('overall_score') ?? 0,
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