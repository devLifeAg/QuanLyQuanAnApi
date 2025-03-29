<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\QuanLyHoaDon;
use App\Models\ChiTietHoaDon;
use App\Models\MonAn;
use App\Models\User;

class QLHoaDonController extends Controller
{
    


    // Thêm hóa đơn
    public function themHoaDon(Request $request)
    {
        $hoadon = QuanLyHoaDon::create([
            'hd_ngaygio' => now(), 
            'hd_tongtien' => $request->input('hd_tongtien'),
            'hd_pttt' => $request->input('hd_pttt'),
            'b_id' => $request->input('b_id'),
            'u_id' => $request->input('u_id')
        ]);

        return response()->json(['result' => 1, 'hoadon' => $hoadon]);
    }

    // Thêm hoặc cập nhật chi tiết hóa đơn
    public function themChiTietHoaDon(Request $request)
{
    // Chỉ lấy các giá trị cần thiết
    $data = $request->only(['mon_id', 'ct_soluong']);

    // Kiểm tra món ăn có tồn tại không
    $monAn = MonAn::find($data['mon_id']);
    if (!$monAn) {
        return response()->json(['error' => 'Món ăn không tồn tại'], 404);
    }

    // Tính thành tiền (ví dụ đơn giản: giá * số lượng)
    $data['ct_thanhtien'] = $monAn->gia * $data['ct_soluong'];

    // Tạo chi tiết hóa đơn
    $chiTiet = ChiTietHoaDon::create($data);

    return response()->json($chiTiet, 201);
}


    // Xóa chi tiết hóa đơn
    public function xoaChiTietHoaDon($ct_id, Request $request)
    {
        $user = User::find($request->input('u_id'));
        if (!$user || ($user->u_role != 1 && $user->u_role != 2)) {
            return response()->json(['result' => 0, 'message' => 'Không có quyền xóa!']);
        }

        $cthd = ChiTietHoaDon::find($ct_id);
        if (!$cthd) return response()->json(['result' => 0, 'message' => 'Không tìm thấy chi tiết hóa đơn!']);
        
        $cthd->delete();
        return response()->json(['result' => 1, 'message' => 'Xóa thành công!']);
    }

    // Thanh toán hóa đơn
    public function thanhToanHoaDon($hd_id)
{
    try {
        $hoadon = QuanLyHoaDon::findOrFail($hd_id);

        // Cập nhật trạng thái thanh toán
        $hoadon->hd_daThanhToan = true;
        $hoadon->save();

        return response()->json([
            'result' => 1,
            'message' => 'Thanh toán thành công!',
            'tongtien' => $hoadon->hd_tongtien
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'result' => 0,
            'message' => 'Không tìm thấy hóa đơn hoặc có lỗi xảy ra!',
            'error' => $e->getMessage()
        ]);
    }
}



}