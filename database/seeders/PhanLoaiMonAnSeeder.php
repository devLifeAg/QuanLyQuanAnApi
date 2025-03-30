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
            ['pl_tenpl' => 'Cơm', 'pl_tenhinh' => MyHelper::uploadImageSeed('com.jpg', false)],
            ['pl_tenpl' => 'Mì', 'pl_tenhinh' => MyHelper::uploadImageSeed('mi.jpg', false)],
            ['pl_tenpl' => 'Canh', 'pl_tenhinh' => MyHelper::uploadImageSeed('canh.jpg', false)],
            ['pl_tenpl' => 'Tráng miệng', 'pl_tenhinh' => MyHelper::uploadImageSeed('trangmieng.jpg', false)],
            ['pl_tenpl' => 'Nước', 'pl_tenhinh' => MyHelper::uploadImageSeed('nuoc.jpg', false)],
        ]);
    }
}

