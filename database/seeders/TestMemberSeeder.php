<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Hash;

class TestMemberSeeder extends Seeder
{
    public function run(): void
    {
        // Get or Create Roles
        $memberRole = Role::firstOrCreate(['name' => 'member', 'label' => 'Member']);
        $mentorRole = Role::firstOrCreate(['name' => 'mentor', 'label' => 'Mentor']);

        // Create Member
        $member = User::updateOrCreate(
            ['email' => 'siswa@syabaab.com'],
            [
                'name' => 'Siswa Tester',
                'password' => Hash::make('password'),
            ]
        );
        $member->roles()->syncWithoutDetaching([$memberRole->id]);

        // Create Mentor
        $mentor = User::updateOrCreate(
            ['email' => 'mentor@syabaab.com'],
            [
                'name' => 'Mentor Tester',
                'password' => Hash::make('password'),
            ]
        );
        $mentor->roles()->syncWithoutDetaching([$mentorRole->id]);

        // Create Category
        $category = CourseCategory::firstOrCreate(['name' => 'Web Development', 'slug' => 'web-development']);

        // Create Course
        $course = Course::updateOrCreate(
            ['slug' => 'belajar-laravel-untuk-pemula'],
            [
                'mentor_id' => $mentor->id,
                'course_category_id' => $category->id,
                'title' => 'Belajar Laravel untuk Pemula',
                'description' => 'Kursus ini mengajarkan dasar-dasar Laravel dari nol.',
                'price' => 0,
                'level' => 'Beginner',
                'is_published' => true,
            ]
        );

        // Create Lessons
        if ($course->lessons()->count() === 0) {
            Lesson::create([
                'course_id' => $course->id,
                'title' => 'Instalasi Laravel',
                'body' => 'Langkah-langkah instalasi Laravel via Composer.',
                'sort_order' => 1,
                'type' => 'video',
                'content_url' => 'https://www.youtube.com/embed/ImtZ5yENzgE', // sample video
                'duration_minutes' => 10,
            ]);

            Lesson::create([
                'course_id' => $course->id,
                'title' => 'Routing dan Controller',
                'body' => 'Memahami routing dan controller di Laravel.',
                'sort_order' => 2,
                'type' => 'text',
                'duration_minutes' => 15,
            ]);
        }

        // Create Quiz
        if (!$course->quiz) {
            $quiz = Quiz::create([
                'course_id' => $course->id,
                'title' => 'Ujian Akhir Laravel Dasar',
                'passing_score' => 80,
            ]);

            // Add Questions
            QuizQuestion::create([
                'quiz_id' => $quiz->id,
                'question' => 'Apa command untuk membuat controller di Laravel?',
                'options' => ['php artisan make:controller', 'php make:controller', 'laravel new controller', 'artisan create:controller'],
                'correct_answer' => 'php artisan make:controller',
            ]);

            QuizQuestion::create([
                'quiz_id' => $quiz->id,
                'question' => 'File konfigurasi utama untuk route web ada di mana?',
                'options' => ['routes/api.php', 'app/Http/routes.php', 'routes/web.php', 'config/routes.php'],
                'correct_answer' => 'routes/web.php',
            ]);
        }

        // Create Other Members for Leaderboard
        $members = [
            ['name' => 'Budi Susanto', 'email' => 'budi@syabaab.com', 'score' => 90, 'speed' => 10], // fast = 50 bonus
            ['name' => 'Siti Aminah', 'email' => 'siti@syabaab.com', 'score' => 85, 'speed' => 20], // medium = 25 bonus
            ['name' => 'Andi Wijaya', 'email' => 'andi@syabaab.com', 'score' => 75, 'speed' => 30], // slow = 0 bonus
        ];

        foreach ($members as $m) {
            $otherMember = User::updateOrCreate(
                ['email' => $m['email']],
                [
                    'name' => $m['name'],
                    'password' => Hash::make('password'),
                ]
            );
            $otherMember->roles()->syncWithoutDetaching([$memberRole->id]);

            // Enroll & complete
            $enr = Enrollment::firstOrCreate([
                'user_id' => $otherMember->id,
                'course_id' => $course->id,
            ], [
                'progress' => 100,
                'created_at' => now()->subMinutes($m['speed'] + 10),
                'completed_at' => now()->subMinutes(10),
            ]);

            // Quiz Attempt
            \App\Models\QuizAttempt::firstOrCreate([
                'user_id' => $otherMember->id,
                'quiz_id' => $quiz->id,
            ], [
                'score' => $m['score'],
                'attempted_at' => now(),
            ]);

            // Update Leaderboard
            \App\Models\LeaderboardScore::recalculateForUser($otherMember->id);
        }

        // Enroll Main Member (Siswa Tester) as ongoing
        Enrollment::firstOrCreate([
            'user_id' => $member->id,
            'course_id' => $course->id,
        ], [
            'progress' => 0,
        ]);
    }
}
