<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ban;
use App\Models\ChiTietHoaDon;
use App\Models\MonAn;
use App\Models\QuanLyHoaDon;
use App\Models\QuanLyKetCa;

class KetCaSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            $time = '-' . $i . ' days';
            $date = date('Y-m-d', strtotime($time));
            $count = QuanLyHoaDon::whereDate('hd_ngaygio', $date)->count();
            $sum = QuanLyHoaDon::whereDate('hd_ngaygio', $date)->sum('hd_tongtien');
            QuanLyKetCa::create([
                'u_id' => 1,
                'kc_tongtien' => $sum,
                'kc_sl_hd' => $count,
                'kc_ngaygio' => $date
            ]);
        }
    }
}
