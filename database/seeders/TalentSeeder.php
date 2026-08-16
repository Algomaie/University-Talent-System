<?php

namespace Database\Seeders;

use App\Models\Talent;
use Illuminate\Database\Seeder;

class TalentSeeder extends Seeder
{
    public function run(): void
    {
        $talents = [
            [
                'name_ar' => 'الشعر والأدب',
                'name_en' => 'Poetry and Literature',
                'description_ar' => 'إبداعات في مجال الشعر والكتابة الأدبية',
                'description_en' => 'Creativity in poetry and literary writing',
                'icon' => 'fas fa-feather-alt',
                'color' => '#8B5CF6',
            ],
            [
                'name_ar' => 'الرسم والفنون التشكيلية',
                'name_en' => 'Drawing and Visual Arts',
                'description_ar' => 'أعمال فنية في الرسم والنحت والفنون التشكيلية',
                'description_en' => 'Artistic works in drawing, sculpture and visual arts',
                'icon' => 'fas fa-palette',
                'color' => '#F59E0B',
            ],
            [
                'name_ar' => 'التصوير الفوتوغرافي',
                'name_en' => 'Photography',
                'description_ar' => 'إبداعات في فن التصوير الفوتوغرافي',
                'description_en' => 'Creative photography works',
                'icon' => 'fas fa-camera',
                'color' => '#10B981',
            ],
            [
                'name_ar' => 'التصميم الجرافيكي',
                'name_en' => 'Graphic Design',
                'description_ar' => 'تصاميم إبداعية ومشاريع جرافيكية',
                'description_en' => 'Creative designs and graphic projects',
                'icon' => 'fas fa-bezier-curve',
                'color' => '#EF4444',
            ],
            [
                'name_ar' => 'الموسيقى والغناء',
                'name_en' => 'Music and Singing',
                'description_ar' => 'إبداعات موسيقية وأعمال غنائية',
                'description_en' => 'Musical creativity and vocal performances',
                'icon' => 'fas fa-music',
                'color' => '#3B82F6',
            ],
            [
                'name_ar' => 'الخطابة والإلقاء',
                'name_en' => 'Public Speaking',
                'description_ar' => 'مهارات في الخطابة والإلقاء والتقديم',
                'description_en' => 'Skills in public speaking and presentation',
                'icon' => 'fas fa-microphone',
                'color' => '#6366F1',
            ],
            [
                'name_ar' => 'المونتاج والإنتاج',
                'name_en' => 'Video Editing and Production',
                'description_ar' => 'إنتاج ومونتاج الفيديوهات والأفلام القصيرة',
                'description_en' => 'Video production and editing of short films',
                'icon' => 'fas fa-video',
                'color' => '#EC4899',
            ],
            [
                'name_ar' => 'البرمجة والتطوير',
                'name_en' => 'Programming and Development',
                'description_ar' => 'مشاريع برمجية وتطبيقات تقنية',
                'description_en' => 'Programming projects and technical applications',
                'icon' => 'fas fa-code',
                'color' => '#059669',
            ],
            [
                'name_ar' => 'الابتكار والاختراع',
                'name_en' => 'Innovation and Invention',
                'description_ar' => 'مشاريع إبداعية وابتكارات تقنية',
                'description_en' => 'Creative projects and technical innovations',
                'icon' => 'fas fa-lightbulb',
                'color' => '#DC2626',
            ],
            [
                'name_ar' => 'ريادة الأعمال',
                'name_en' => 'Entrepreneurship',
                'description_ar' => 'مشاريع ريادية وأفكار تجارية مبتكرة',
                'description_en' => 'Entrepreneurial projects and innovative business ideas',
                'icon' => 'fas fa-rocket',
                'color' => '#7C3AED',
            ],
        ];

        foreach ($talents as $talent) {
            Talent::create($talent);
        }
    }
}