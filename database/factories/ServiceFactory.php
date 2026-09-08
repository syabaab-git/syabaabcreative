<?php

namespace Database\Factories;

use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->randomElement([
            'Desain Katalog Produk Premium',
            'Website Company Profile',
            'Branding Kit UMKM',
            'Social Media Management',
            'Digital Marketing Campaign',
        ]) . ' ' . fake()->numberBetween(1, 99);

        return [
            'service_category_id' => ServiceCategory::inRandomOrder()->first()->id,
            'thumbnail' => null,
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraph(5),
            'packages' => [
                [
                    'name' => 'Basic',
                    'price' => 250000,
                    'features' => ['Konsep dasar', '1 revisi'],
                ],
                [
                    'name' => 'Pro',
                    'price' => 750000,
                    'features' => ['Desain premium', '3 revisi', 'File source'],
                ],
                [
                    'name' => 'Business',
                    'price' => 1500000,
                    'features' => ['Strategi lengkap', 'Unlimited minor revision', 'Priority support'],
                ],
            ],
            'base_price' => fake()->randomElement([250000, 500000, 750000, 1500000]),
            'estimated_days' => fake()->randomElement(['3-5 hari', '7 hari', '14 hari']),
            'is_active' => true,
        ];
    }
}
