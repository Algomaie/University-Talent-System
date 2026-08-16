<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        if (!User::where('email', 'admin@university.edu')->exists()) {
            User::create([
                'name' => 'مدير النظام',
                'email' => 'admin@university.edu',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
        }

        // Create Manager Users
        $managers = [
            [
                'name' => 'د. أحمد محمد',
                'email' => 'manager1@university.edu',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'د. فاطمة علي',
                'email' => 'manager2@university.edu',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'د. محمد السعيد',
                'email' => 'manager3@university.edu',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($managers as $manager) {
            if (!User::where('email', $manager['email'])->exists()) {
                User::create($manager);
            }
        }

        // Create Student Users
        $students = [
            [
                'name' => 'سارة أحمد محمد',
                'email' => 'sara@student.university.edu',
                'password' => Hash::make('password'),
                'role' => 'student',
                'student_id' => '202001001',
                'department' => 'علوم الحاسب',
                'academic_level' => 'السنة الثالثة',
                'phone' => '+966501234567',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'محمد عبدالله',
                'email' => 'mohammed@student.university.edu',
                'password' => Hash::make('password'),
                'role' => 'student',
                'student_id' => '202001002',
                'department' => 'الهندسة',
                'academic_level' => 'السنة الثانية',
                'phone' => '+966501234568',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'نور الهدى',
                'email' => 'noor@student.university.edu',
                'password' => Hash::make('password'),
                'role' => 'student',
                'student_id' => '202001003',
                'department' => 'التصميم الجرافيكي',
                'academic_level' => 'السنة الرابعة',
                'phone' => '+966501234569',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'عبدالرحمن خالد',
                'email' => 'abdulrahman@student.university.edu',
                'password' => Hash::make('password'),
                'role' => 'student',
                'student_id' => '202001004',
                'department' => 'إدارة الأعمال',
                'academic_level' => 'السنة الأولى',
                'phone' => '+966501234570',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'ليلى عبدالعزيز',
                'email' => 'layla@student.university.edu',
                'password' => Hash::make('password'),
                'role' => 'student',
                'student_id' => '202001005',
                'department' => 'الأدب العربي',
                'academic_level' => 'السنة الثالثة',
                'phone' => '+966501234571',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($students as $student) {
            if (!User::where('email', $student['email'])->exists()) {
                User::create($student);
            }
        }
    }
}