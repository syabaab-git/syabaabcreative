<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\Service;
use App\Models\CourseCategory;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'super-admin', 'label' => 'Super Admin'],
            ['name' => 'mentor', 'label' => 'Mentor'],
            ['name' => 'agency-staff', 'label' => 'Agency Staff'],
            ['name' => 'member', 'label' => 'Member'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }

        $admin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->roles()->attach(Role::where('name', 'super-admin')->first());

        $mentor = User::factory()->create([
            'name' => 'Mentor Creative',
            'email' => 'mentor@example.com',
            'password' => Hash::make('password'),
        ]);
        $mentor->roles()->attach(Role::where('name', 'mentor')->first());

        $staff = User::factory()->create([
            'name' => 'Agency Staff',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
        ]);
        $staff->roles()->attach(Role::where('name', 'agency-staff')->first());

        $courseCategories = [
            'Desain Grafis',
            'UI/UX Design',
            'Digital Marketing',
            'Content Creator',
            'AI Tools',
            'Programming',
            'Business',
        ];

        foreach ($courseCategories as $name) {
            CourseCategory::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => 'Kategori ' . $name,
            ]);
        }

        $serviceCategories = [
            'Desain Katalog Produk',
            'Company Profile',
            'Desain Sosial Media',
            'Website Development',
            'Branding Kit',
            'Digital Marketing',
        ];

        foreach ($serviceCategories as $name) {
            ServiceCategory::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => 'Layanan ' . $name,
            ]);
        }

        Course::factory(12)->create([
            'mentor_id' => $mentor->id,
        ]);

        Service::factory(10)->create();
    }
}
