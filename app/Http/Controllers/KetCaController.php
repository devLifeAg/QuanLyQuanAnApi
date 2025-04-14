<?php

namespace App\Http\Controllers;

use App\Models\QuanLyHoaDon;
use App\Models\QuanLyKetCa;
use App\Models\User;
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
            'giobatdauban' => now()->setHour(7)->setMinute(0)->setSecond(0),
            'giohientai' => now(),
            'tongtien' => $tongTien,
            'soluonghoadon' => $soLuongHD,
        ]);
    }

    public function taoKetCa($id)
    {
        // Kiểm tra quyền user
        $user = User::findOrFail($id);
        if ($user->u_role == 3) {
            return response()->json(['error' => 'Tài khoản này không có quyền tạo kết ca'], 403);
        }

        $hoaDons = QuanLyHoaDon::whereDate('hd_ngaygio', now())
            ->where('hd_daThanhToan', 1)
            ->get();

        $tongTien = $hoaDons->sum('hd_tongtien');
        $soLuongHD = $hoaDons->count();

        // Kiểm tra nếu không có hóa đơn hoặc tổng tiền = 0 thì không tạo kết ca
        if ($tongTien == 0 || $soLuongHD == 0) {
            return response()->json(['error' => 'Không thể tạo kết ca vì chưa có hóa đơn hoặc tổng tiền bằng 0'], 400);
        }

        $ketCa = QuanLyKetCa::create([
            'u_id' => $id,
            'kc_tongtien' => $tongTien,
            'kc_sl_hd' => $soLuongHD,
            'kc_ngaygio' => now()
        ]);

        return response()->json(['message' => 'Tạo kết ca thành công','ketca' => $ketCa], 201);
    }


    public function getDSKetCa()
    {
        $dsKetCa = QuanLyKetCa::all();

        return response()->json([
            'result' => 1,
            'danhsachketca' => $dsKetCa
        ]);
    }

    public function getHoaDonOfKetCa($id)
    {
        $ketCa = QuanLyKetCa::findOrFail($id);
        $ngayGioKetCa = Carbon::parse($ketCa->kc_ngaygio)->setTimezone('Asia/Ho_Chi_Minh')->toDateString();
        $danhsachhoadon = QuanLyHoaDon::whereDate('hd_ngaygio', $ngayGioKetCa)->where('hd_daThanhToan', 1)->get();
        return response()->json([
            'result' => 1,
            'danhsachhoadon' => $danhsachhoadon
        ]);
    }
}
