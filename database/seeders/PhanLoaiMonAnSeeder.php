<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PhanLoaiMonAn;
use App\Helpers\MyHelper;

class PhanLoaiMonAnSeeder extends Seeder
{
    public function run()
    {
        PhanLoaiMonAn::insert([
            ['pl_tenpl' => 'Cơm', 'pl_tenhinh' => 'cc'],
            ['pl_tenpl' => 'Mì', 'pl_tenhinh' => 'cc'],
            ['pl_tenpl' => 'Canh', 'pl_tenhinh' => 'cc'],
            ['pl_tenpl' => 'Tráng miệng', 'pl_tenhinh' => 'cc'],
            ['pl_tenpl' => 'Nước', 'pl_tenhinh' => 'cc'],
        ]);
    }
}

