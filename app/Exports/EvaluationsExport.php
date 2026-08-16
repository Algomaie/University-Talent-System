<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EvaluationsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $evaluations;

    public function __construct($evaluations)
    {
        $this->evaluations = $evaluations;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->evaluations;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Submission ID',
            'Student Name',
            'Competition',
            'Evaluator',
            'Creativity Score',
            'Technical Score',
            'Presentation Score',
            'Overall Score',
            'Comments',
            'Evaluated At',
        ];
    }

    /**
     * @param mixed $evaluation
     * @return array
     */
    public function map($evaluation): array
    {
        return [
            $evaluation->id,
            $evaluation->submission_id,
            $evaluation->submission->user->name ?? '',
            $evaluation->submission->competition->title ?? '',
            $evaluation->evaluator->name ?? '',
            $evaluation->creativity_score,
            $evaluation->technical_score,
            $evaluation->presentation_score,
            $evaluation->overall_score,
            $evaluation->comments,
            $evaluation->created_at ? $evaluation->created_at->format('Y-m-d H:i:s') : '',
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