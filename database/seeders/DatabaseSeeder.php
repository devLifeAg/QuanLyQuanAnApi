<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $usernames = ['admin', 'quanly', 'thungan', 'nhanvien'];
        $names = ['Admin', 'Quản Lý', 'Thu Ngân', 'Nhân Viên'];
        // Lặp qua danh sách user để tạo tài khoản
        foreach ($usernames as $key => $username) {
            User::create([
                'u_username' => $username,
                'u_pass' => Hash::make($username),
                'u_role' => $key,
                'u_name' => $names[$key],
            ]);
        }
        $this->call([
            TangSeeder::class,
            BanSeeder::class,
            PhanLoaiMonAnSeeder::class,
            MonAnSeeder::class,
            HoaDonSeeder::class,
            KetCaSeeder::class
        ]);
    }

}
