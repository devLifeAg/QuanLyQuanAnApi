<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PhanLoaiMonAn;

class PhanLoaiMonAnSeeder extends Seeder
{
    public function run()
    {
        PhanLoaiMonAn::insert([
            ['pl_tenpl' => 'Cơm', 'pl_tenhinh' => 'com.jpg'],
            ['pl_tenpl' => 'Mì', 'pl_tenhinh' => 'mi.jpg'],
            ['pl_tenpl' => 'Canh', 'pl_tenhinh' => 'canh.jpg'],
            ['pl_tenpl' => 'Tráng miệng', 'pl_tenhinh' => 'trangmieng.jpg'],
            ['pl_tenpl' => 'Nước', 'pl_tenhinh' => 'nuoc.jpg'],
        ]);
    }
}

