<?php

namespace App\Http\Controllers;

use App\Models\QuanLyHoaDon;
use App\Models\QuanLyKetCa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KetCaController
{
    public function xemPreviewKetCa()
    {

        $hoaDons = QuanLyHoaDon::whereDate('hd_ngaygio', now())->where('hd_daThanhToan', 1)->get();
        $tongTien = $hoaDons->sum('hd_tongtien');
        $soLuongHD = $hoaDons->count();

        return response()->json([
            'giobatdauban' => now()->setHour(9)->setMinute(0)->setSecond(0),
            'giohientai' => now(),
            'tongTien' => $tongTien,
            'soLuongHD' => $soLuongHD,
        ]);
    }

    public function taoKetCa($id)
    {
        if (now()->hour < 21) {
            return response()->json(['error' => 'Chỉ có thể tạo kết ca sau 9h tối'], 403);
        }

        $hoaDons = QuanLyHoaDon::whereDate('hd_ngaygio', now())->where('hd_daThanhToan', 1)->get();
        $tongTien = $hoaDons->sum('hd_tongtien');
        $soLuongHD = $hoaDons->count();
        $ketCa = QuanLyKetCa::create([
            'u_id' => $id,
            'kc_tongtien' => $tongTien,
            'kc_sl_hd' => $soLuongHD,
            'kc_ngaygio' => now()
        ]);

        return response()->json($ketCa, 201);
    }

    public function getDSKetCa()
    {
        return response()->json(QuanLyKetCa::all());
    }

    public function getHoaDonOfKetCa($id)
    {
        $ketCa = QuanLyKetCa::findOrFail($id);
        $ngayGioKetCa = Carbon::parse($ketCa->kc_ngaygio)->setTimezone('Asia/Ho_Chi_Minh')->toDateString();
        $danhsachhoadon = QuanLyHoaDon::whereDate('hd_ngaygio', $ngayGioKetCa)->where('hd_daThanhToan', 1)->get();
        return response()->json($danhsachhoadon);
    }
}
