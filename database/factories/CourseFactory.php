<?php

namespace Database\Factories;

use App\Models\CourseCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CourseFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->randomElement([
            'Mastering Graphic Design',
            'Digital Marketing Fundamental',
            'AI Productivity for Business',
            'Programming Dasar Laravel',
            'Content Creation Bootcamp',
        ]) . ' ' . fake()->numberBetween(1, 99);

        return [
            'course_category_id' => CourseCategory::inRandomOrder()->first()->id,
            'mentor_id' => User::whereHas('roles', fn ($q) => $q->where('name', 'mentor'))->first()->id,
            'thumbnail' => null,
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraph(4),
            'price' => fake()->randomElement([99000, 149000, 249000, 499000]),
            'level' => fake()->randomElement(['beginner', 'intermediate', 'advanced']),
            'rating' => fake()->randomFloat(2, 4, 5),
            'students_count' => fake()->numberBetween(10, 1000),
            'is_published' => true,
        ];
    }
}
