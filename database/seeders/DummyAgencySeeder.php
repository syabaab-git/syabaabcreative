<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Str;

class DummyAgencySeeder extends Seeder
{
    public function run()
    {
        // Temukan akun staff pertama yang ada
        $staff = User::whereHas('roles', function($q) {
            $q->where('name', 'agency-staff');
        })->first();

        // Kalau belum ada staff, bikin satu (meski sudah ada sebelumnya)
        if (!$staff) {
            $staff = User::create([
                'name' => 'Agency Staff',
                'email' => 'staff@gmail.com',
                'password' => bcrypt('password'),
            ]);
            $staff->assignRole('agency-staff');
        }

        // Pastikan ada kategori layanan
        $category = \App\Models\ServiceCategory::firstOrCreate(
            ['slug' => 'website-development'],
            [
                'name' => 'Website Development',
                'description' => 'Kategori untuk semua layanan pembuatan website.',
                'icon' => 'globe'
            ]
        );

        // Pastikan ada layanan
        $service1 = Service::firstOrCreate(
            ['slug' => 'website-company-profile'],
            [
                'service_category_id' => $category->id,
                'title' => 'Pembuatan Website Company Profile',
                'description' => 'Website profesional untuk perusahaan.',
                'base_price' => 5000000,
                'is_active' => true
            ]
        );

        $service2 = Service::firstOrCreate(
            ['slug' => 'desain-logo-branding'],
            [
                'service_category_id' => $category->id,
                'title' => 'Desain Logo & Branding',
                'description' => 'Branding kit lengkap.',
                'base_price' => 2000000,
                'is_active' => true
            ]
        );

        // Buat 5 Pesanan
        $ordersData = [
            ['customer_name' => 'PT Makmur Jaya', 'customer_email' => 'contact@makmurjaya.com', 'service_id' => $service1->id, 'status' => 'processing'],
            ['customer_name' => 'Toko Laris', 'customer_email' => 'info@tokolaris.id', 'service_id' => $service2->id, 'status' => 'pending'],
            ['customer_name' => 'Klinik Sehat', 'customer_email' => 'admin@kliniksehat.com', 'service_id' => $service1->id, 'status' => 'completed'],
            ['customer_name' => 'CV Abadi', 'customer_email' => 'hello@cvabadi.co.id', 'service_id' => $service2->id, 'status' => 'processing'],
            ['customer_name' => 'Bapak Budi', 'customer_email' => 'budi.developer@gmail.com', 'service_id' => $service1->id, 'status' => 'pending'],
        ];

        foreach ($ordersData as $idx => $data) {
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'user_id' => $staff->id, // Just linking it to staff user for dummy
                'service_id' => $data['service_id'],
                'customer_name' => $data['customer_name'],
                'email' => $data['customer_email'],
                'whatsapp' => '0812345678' . $idx,
                'requirement' => 'Tolong kerjakan secepatnya.',
                'amount' => 5000000,
                'status' => $data['status'],
            ]);

            // Buat project untuk yang statusnya processing atau completed
            if (in_array($data['status'], ['processing', 'completed'])) {
                $progress = $data['status'] === 'completed' ? 100 : rand(10, 85);
                Project::create([
                    'order_id' => $order->id,
                    'staff_id' => $staff->id,
                    'title' => 'Project: ' . ($order->service->title ?? 'Custom'),
                    'status' => $data['status'] === 'completed' ? 'completed' : (rand(0,1) ? 'in_progress' : 'review'),
                    'progress' => $progress,
                    'deadline' => now()->addDays(rand(-2, 14)), // Beberapa ada yang telat (-2 hari) atau akan datang
                ]);
            }
        }
    }
}
