<?php

namespace Database\Seeders;

use App\Models\Competition;
use App\Models\Talent;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CompetitionSeeder extends Seeder
{
    public function run(): void
    {
        $talentIds = Talent::pluck('id')->toArray();

        $competitions = [
            [
                'title_ar' => 'مسابقة الإبداع الطلابي 2024',
                'title_en' => 'Student Creativity Competition 2024',
                'description_ar' => 'مسابقة سنوية لاكتشاف وتنمية المواهب الطلابية في مختلف المجالات الإبداعية والتقنية.',
                'description_en' => 'Annual competition to discover and develop student talents in various creative and technical fields.',
                'start_date' => Carbon::now()->addDays(5),
                'end_date' => Carbon::now()->addDays(60),
                'registration_deadline' => Carbon::now()->addDays(30),
                'max_participants' => 100,
                'allowed_talents' => $talentIds,
                'status' => 'active',
                'created_by' => 1, // Admin user
            ],
            [
                'title_ar' => 'مسابقة التصوير الفوتوغرافي',
                'title_en' => 'Photography Competition',
                'description_ar' => 'مسابقة متخصصة في فن التصوير الفوتوغرافي للطلاب المبدعين.',
                'description_en' => 'Specialized photography competition for creative students.',
                'start_date' => Carbon::now()->addDays(10),
                'end_date' => Carbon::now()->addDays(45),
                'registration_deadline' => Carbon::now()->addDays(25),
                'max_participants' => 50,
                'allowed_talents' => [3], // Photography only
                'status' => 'active',
                'created_by' => 2, // Manager user
            ],
            [
                'title_ar' => 'مسابقة البرمجة والابتكار',
                'title_en' => 'Programming and Innovation Competition',
                'description_ar' => 'مسابقة لأفضل المشاريع البرمجية والابتكارات التقنية.',
                'description_en' => 'Competition for the best programming projects and technical innovations.',
                'start_date' => Carbon::now()->addDays(15),
                'end_date' => Carbon::now()->addDays(75),
                'registration_deadline' => Carbon::now()->addDays(40),
                'max_participants' => 75,
                'allowed_talents' => [8, 9], // Programming and Innovation
                'status' => 'active',
                'created_by' => 3, // Manager user
            ],
        ];

        foreach ($competitions as $competition) {
            Competition::create($competition);
        }
    }
}