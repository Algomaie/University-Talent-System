<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {name} {email} {password} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');
        $role = $this->argument('role');

        // Validate role
        if (!in_array($role, ['student', 'manager', 'admin'])) {
            $this->error('Invalid role. Must be student, manager, or admin.');
            return 1;
        }

        // Check if user already exists
        if (User::where('email', $email)->exists()) {
            $this->error('User with this email already exists.');
            return 1;
        }

        // Create the user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
            'student_id' => $role === 'student' ? 'STU' . rand(1000, 9999) : null,
            'department' => $role === 'student' ? 'Computer Science' : null,
            'academic_level' => $role === 'student' ? 'Third Year' : null,
            'phone' => '+1234567890',
            'is_active' => true,
        ]);

        $this->info('User created successfully!');
        $this->info("ID: {$user->id}");
        $this->info("Name: {$user->name}");
        $this->info("Email: {$user->email}");
        $this->info("Role: {$user->role}");

        return 0;
    }
}