<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Consultation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'ماسترويب',
            'email' => 'admin@gmail.com',
            'password' => '12345678',
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'محمد السبيعي',
            'email' => 'mohamed@gmail.com',
            'password' => '12345678',
            'role' => 'seller',
        ]);
        User::create([
            'name' => 'أحمد السبيعي',
            'email' => 'ahmed@gmail.com',
            'password' => '12345678',
            'role' => 'buyer',
        ]);
        User::create([
            'name' => 'امجد علي السبيعي',
            'email' => 'amjad@gmail.com',
            'password' => '12345678',
            'role' => 'consultant',
            'specialization' => 'علوم تربة',
            'image' => 'images/users/consultant.jpeg',
        ]);
        User::create([
            'name' => 'عبدالله السبيعي',
            'email' => 'abdallah@gmail.com',
            'password' => '12345678',
            'role' => 'consultant',
            'specialization' => 'علوم تربة',
            'image' => 'images/users/consultant.jpeg',
        ]);
        User::create([
            'name' => ' علي السبيعي',
            'email' => 'ali@gmail.com',
            'password' => '12345678',
            'role' => 'consultant',
            'specialization' => 'علوم طبيعة',
            'image' => 'images/users/consultant.jpeg',
        ]);
        Consultation::create([
            'consultant_id' => 4,
            'price' => 100,
        ]);
        Consultation::create([
            'consultant_id' => 5,
            'price' => 50,
        ]);
        Consultation::create([
            'consultant_id' => 6,
            'price' => 80,
        ]);
        Certificate::create([
            'image_path' => 'images/users/consultants/Rectangle 11.png',
            'consultant_id' => 4,
            'title' => 'علوم طبيعة',
        ]);
        Certificate::create([
            'image_path' => 'images/users/consultants/Rectangle 11.png',
            'consultant_id' => 5,
            'title' => 'علوم تربة',
        ]);
        Certificate::create([
            'image_path' => 'images/users/consultants/Rectangle 11.png',
            'consultant_id' => 6,
            'title' => 'علوم تربة',
        ]);
    }
}
