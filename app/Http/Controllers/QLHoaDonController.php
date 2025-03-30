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

    // Sửa hóa đơn
    public function suaHoaDon($hd_id, Request $request)
    {
        try {
            $hoadon = QuanLyHoaDon::findOrFail($hd_id);

            $hoadon->update($request->only(['hd_tongtien', 'hd_pttt', 'b_id', 'u_id']));

            return response()->json(['result' => 1, 'message' => 'Cập nhật hóa đơn thành công!', 'hoadon' => $hoadon]);
        } catch (\Exception $e) {
            return response()->json(['result' => 0, 'message' => 'Không tìm thấy hóa đơn hoặc có lỗi xảy ra!', 'error' => $e->getMessage()]);
        }
    }

    // Xóa hóa đơn
    public function xoaHoaDon($hd_id)
    {
        try {
            $hoadon = QuanLyHoaDon::findOrFail($hd_id);
            $hoadon->delete();

            return response()->json(['result' => 1, 'message' => 'Xóa hóa đơn thành công!']);
        } catch (\Exception $e) {
            return response()->json(['result' => 0, 'message' => 'Không tìm thấy hóa đơn hoặc có lỗi xảy ra!', 'error' => $e->getMessage()]);
        }
    }

    // Thêm hoặc cập nhật chi tiết hóa đơn
    public function themChiTietHoaDon(Request $request)
    {
        $data = $request->only(['mon_id', 'ct_soluong']);
        $monAn = MonAn::find($data['mon_id']);
        if (!$monAn) {
            return response()->json(['error' => 'Món ăn không tồn tại'], 404);
        }

        $data['ct_thanhtien'] = $monAn->gia * $data['ct_soluong'];
        $chiTiet = ChiTietHoaDon::create($data);

        return response()->json($chiTiet, 201);
    }

    // Sửa chi tiết hóa đơn
    public function suaChiTietHoaDon($ct_id, Request $request)
    {
        try {
            $chiTiet = ChiTietHoaDon::findOrFail($ct_id);

            $monAn = MonAn::find($request->input('mon_id'));
            if (!$monAn) {
                return response()->json(['result' => 0, 'message' => 'Món ăn không tồn tại!']);
            }

            $chiTiet->update([
                'mon_id' => $request->input('mon_id'),
                'ct_soluong' => $request->input('ct_soluong'),
                'ct_thanhtien' => $monAn->gia * $request->input('ct_soluong')
            ]);

            return response()->json(['result' => 1, 'message' => 'Sửa chi tiết hóa đơn thành công!', 'chitiet' => $chiTiet]);
        } catch (\Exception $e) {
            return response()->json(['result' => 0, 'message' => 'Không tìm thấy chi tiết hóa đơn hoặc có lỗi xảy ra!', 'error' => $e->getMessage()]);
        }
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
