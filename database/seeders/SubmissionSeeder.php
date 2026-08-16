<?php

namespace Database\Seeders;

use App\Models\Submission;
use App\Models\User;
use App\Models\Competition;
use App\Models\Talent;
use App\Models\Evaluation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SubmissionSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::students()->get();
        $competitions = Competition::all();
        $managers = User::managers()->get();

        // Create sample submissions
        $submissions = [
            [
                'user_id' => $students[0]->id, // Sara
                'competition_id' => $competitions[0]->id,
                'talent_id' => 4, // Graphic Design
                'title' => 'تصميم هوية بصرية لمشروع تقني',
                'description' => 'مشروع تصميم هوية بصرية كاملة لشركة تقنية ناشئة، يتضمن الشعار والألوان والخطوط والمواد التسويقية.',
                'status' => 'under_review',
                'submitted_at' => Carbon::now()->subDays(5),
            ],
            [
                'user_id' => $students[1]->id, // Mohammed
                'competition_id' => $competitions[2]->id,
                'talent_id' => 8, // Programming
                'title' => 'تطبيق إدارة المهام للطلاب',
                'description' => 'تطبيق ويب متكامل لإدارة المهام والواجبات الدراسية مع نظام تذكير ذكي ومزامنة سحابية.',
                'status' => 'nominated',
                'submitted_at' => Carbon::now()->subDays(8),
            ],
            [
                'user_id' => $students[2]->id, // Noor
                'competition_id' => $competitions[1]->id,
                'talent_id' => 3, // Photography
                'title' => 'سلسلة صور الطبيعة الصحراوية',
                'description' => 'مجموعة من الصور الفوتوغرافية التي تُظهر جمال الطبيعة الصحراوية في المملكة العربية السعودية.',
                'status' => 'approved',
                'submitted_at' => Carbon::now()->subDays(12),
            ],
            [
                'user_id' => $students[3]->id, // Abdulrahman
                'competition_id' => $competitions[0]->id,
                'talent_id' => 10, // Entrepreneurship
                'title' => 'مشروع منصة التجارة الإلكترونية للحرفيين',
                'description' => 'فكرة مشروع منصة إلكترونية تربط الحرفيين المحليين بالعملاء مباشرة مع نظام دفع آمن وخدمات لوجستية.',
                'status' => 'under_review',
                'submitted_at' => Carbon::now()->subDays(3),
            ],
            [
                'user_id' => $students[4]->id, // Layla
                'competition_id' => $competitions[0]->id,
                'talent_id' => 1, // Poetry
                'title' => 'ديوان شعري بعنوان "أصداء الروح"',
                'description' => 'مجموعة شعرية تتناول مواضيع متنوعة من الحب والطبيعة والوطن بأسلوب شاعري معاصر.',
                'status' => 'pending',
                'submitted_at' => Carbon::now()->subDays(1),
            ],
        ];

        foreach ($submissions as $submissionData) {
            $submission = Submission::create($submissionData);

            // Create evaluations for some submissions
            if (in_array($submission->status, ['under_review', 'nominated', 'approved'])) {
                $manager = $managers->random();
                
                Evaluation::create([
                    'submission_id' => $submission->id,
                    'evaluator_id' => $manager->id,
                    'creativity_score' => rand(7, 10),
                    'technical_score' => rand(6, 10),
                    'presentation_score' => rand(7, 9),
                    'overall_score' => rand(7, 9),
                    'comments' => 'عمل متميز يُظهر إبداعاً وابتكاراً في التنفيذ. يُنصح بتطوير بعض الجوانب التقنية.',
                    'is_nominated' => $submission->status === 'nominated',
                    'nomination_reason' => $submission->status === 'nominated' 
                        ? 'مشروع استثنائي يستحق الترشيح للمرحلة النهائية لجودة التنفيذ والفكرة المبتكرة.'
                        : null,
                ]);
            }
        }
    }
}
