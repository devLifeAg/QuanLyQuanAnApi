<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ban;
use App\Models\ChiTietHoaDon;
use App\Models\MonAn;
use App\Models\QuanLyHoaDon;

class HoaDonSeeder extends Seeder
{
    public function run()
    {
        $dates = [];

        for ($i = 0; $i < 5; $i++) {
            $time = '-' . $i . ' days';
            for($y = 0; $y < 5; $y++){
                $date = date('Y-m-d h:i:s', strtotime($time));
                $dates[] = $date;
            }
        }
        foreach ($dates as $date) {
            $hd = QuanLyHoaDon::create([
                'hd_ngaygio' => $date, 
            'hd_tongtien' => 0,
            'hd_pttt' => 1,
            'hd_daThanhToan' => 1,
            'b_id' => 1,
            'u_id' => 1
            ]);
            for($i=0; $i < 5; $i++){
                $giaMon = MonAn::where('mon_id', $i + 1)->value('mon_giamon');
                ChiTietHoaDon::create([
                    'mon_id' => $i+1,
                    'ct_soluong' => 2,
                    'ct_thanhtien'=> $giaMon * 2,
                    'hd_id' => $hd->hd_id
                ]);
            }
            $tongTien = ChiTietHoaDon::where('hd_id', $hd->hd_id)->sum('ct_thanhtien');
            $hd->update(['hd_tongtien' => $tongTien]);
        }
    }
}
