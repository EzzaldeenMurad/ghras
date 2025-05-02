<?php

namespace Database\Seeders;

use App\Models\ConsultantImage;
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
            'image' => 'images/users/consultants1.png',
        ]);
        User::create([
            'name' => 'عبدالله السبيعي',
            'email' => 'abdallah@gmail.com',
            'password' => '12345678',
            'role' => 'consultant',
            'image' => 'images/users/consultant2.png',
        ]);
        User::create([
            'name' => ' علي السبيعي',
            'email' => 'ali@gmail.com',
            'password' => '12345678',
            'role' => 'consultant',
            'image' => 'images/users/consultant3.png',
        ]);
        ConsultantImage::create([
            'image_url' => 'images/users/consultants/Rectangle 11.png',
            'consultant_id' => 4
        ]);
        ConsultantImage::create([
            'image_url' => 'images/users/consultants/Rectangle 11.png',
            'consultant_id' => 5
        ]);
        ConsultantImage::create([
            'image_url' => 'images/users/consultants/Rectangle 11.png',
            'consultant_id' => 6
        ]);
    }
}
