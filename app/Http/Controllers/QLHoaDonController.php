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
    // // Thêm hóa đơn
    // public function themHoaDon(Request $request)
    // {
    //     $hoadon = QuanLyHoaDon::create([
    //         'hd_ngaygio' => now(), 
    //         'hd_tongtien' => $request->input('hd_tongtien'),
    //         'hd_pttt' => $request->input('hd_pttt'),
    //         'b_id' => $request->input('b_id'),
    //         'u_id' => $request->input('u_id')
    //     ]);

    //     return response()->json(['result' => 1, 'hoadon' => $hoadon]);
    // }

    // // Sửa hóa đơn
    // public function suaHoaDon($hd_id, Request $request)
    // {
    //     try {
    //         $hoadon = QuanLyHoaDon::findOrFail($hd_id);

    //         $hoadon->update($request->only(['hd_tongtien', 'hd_pttt', 'b_id', 'u_id']));

    //         return response()->json(['result' => 1, 'message' => 'Cập nhật hóa đơn thành công!', 'hoadon' => $hoadon]);
    //     } catch (\Exception $e) {
    //         return response()->json(['result' => 0, 'message' => 'Không tìm thấy hóa đơn hoặc có lỗi xảy ra!', 'error' => $e->getMessage()]);
    //     }
    // }

    // // Xóa hóa đơn
    // public function xoaHoaDon($hd_id)
    // {
    //     try {
    //         $hoadon = QuanLyHoaDon::findOrFail($hd_id);
    //         $hoadon->delete();

    //         return response()->json(['result' => 1, 'message' => 'Xóa hóa đơn thành công!']);
    //     } catch (\Exception $e) {
    //         return response()->json(['result' => 0, 'message' => 'Không tìm thấy hóa đơn hoặc có lỗi xảy ra!', 'error' => $e->getMessage()]);
    //     }
    // }

    // // Thêm hoặc cập nhật chi tiết hóa đơn
    // public function themChiTietHoaDon(Request $request)
    // {
    //     $data = $request->only(['mon_id', 'ct_soluong']);
    //     $monAn = MonAn::find($data['mon_id']);
    //     if (!$monAn) {
    //         return response()->json(['error' => 'Món ăn không tồn tại'], 404);
    //     }

    //     $data['ct_thanhtien'] = $monAn->gia * $data['ct_soluong'];
    //     $chiTiet = ChiTietHoaDon::create($data);

    //     return response()->json($chiTiet, 201);
    // }

    // // Sửa chi tiết hóa đơn
    // public function suaChiTietHoaDon($ct_id, Request $request)
    // {
    //     try {
    //         $chiTiet = ChiTietHoaDon::findOrFail($ct_id);

    //         $monAn = MonAn::find($request->input('mon_id'));
    //         if (!$monAn) {
    //             return response()->json(['result' => 0, 'message' => 'Món ăn không tồn tại!']);
    //         }

    //         $chiTiet->update([
    //             'mon_id' => $request->input('mon_id'),
    //             'ct_soluong' => $request->input('ct_soluong'),
    //             'ct_thanhtien' => $monAn->gia * $request->input('ct_soluong')
    //         ]);

    //         return response()->json(['result' => 1, 'message' => 'Sửa chi tiết hóa đơn thành công!', 'chitiet' => $chiTiet]);
    //     } catch (\Exception $e) {
    //         return response()->json(['result' => 0, 'message' => 'Không tìm thấy chi tiết hóa đơn hoặc có lỗi xảy ra!', 'error' => $e->getMessage()]);
    //     }
    // }

    // // Xóa chi tiết hóa đơn
    // public function xoaChiTietHoaDon($ct_id, Request $request)
    // {
    //     $user = User::find($request->input('u_id'));
    //     if (!$user || ($user->u_role != 1 && $user->u_role != 2)) {
    //         return response()->json(['result' => 0, 'message' => 'Không có quyền xóa!']);
    //     }

    //     $cthd = ChiTietHoaDon::find($ct_id);
    //     if (!$cthd) return response()->json(['result' => 0, 'message' => 'Không tìm thấy chi tiết hóa đơn!']);

    //     $cthd->delete();
    //     return response()->json(['result' => 1, 'message' => 'Xóa thành công!']);
    // }

    // // Thanh toán hóa đơn
    // public function thanhToanHoaDon($hd_id)
    // {
    //     try {
    //         $hoadon = QuanLyHoaDon::findOrFail($hd_id);
    //         $hoadon->hd_daThanhToan = true;
    //         $hoadon->save();

    //         return response()->json([
    //             'result' => 1,
    //             'message' => 'Thanh toán thành công!',
    //             'tongtien' => $hoadon->hd_tongtien
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'result' => 0,
    //             'message' => 'Không tìm thấy hóa đơn hoặc có lỗi xảy ra!',
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }

    public function taoOrder(Request $request)
    {

        $uId = $request->input('u_id');
        $banId = $request->input('b_id');
        $danhSachMonOrder = $request->input('items');
        if (empty($uId) || empty($banId) || count($danhSachMonOrder) === 0) {
            return response()->json([
                'message' => 'chưa có chi tiết hóa đơn hoặc lỗi mã bàn, mã nhân viên',
            ], 500);
        }

        try {
            DB::beginTransaction(); // bắt đầu transaction
            $hd = QuanLyHoaDon::create([
                'hd_ngaygio' => date('Y-m-d h:i:s'),
                'hd_tongtien' => 0,
                'hd_pttt' => 0,
                'hd_daThanhToan' => 0,
                'b_id' => $banId,
                'u_id' => $uId,
            ]);

            foreach ($danhSachMonOrder as $order) {
                $mon_id = $order['food_id'];
                $soLuong = $order['quantity'];
                $giaMon = MonAn::where('mon_id', $mon_id)->value('mon_giamon');
                ChiTietHoaDon::create([
                    'mon_id' => $mon_id,
                    'ct_soluong' => $soLuong,
                    'ct_thanhtien' => $giaMon * $soLuong,
                    'hd_id' => $hd->hd_id
                ]);
            }
            $tongTien = ChiTietHoaDon::where('hd_id', $hd->hd_id)->sum('ct_thanhtien');
            $hd->update(['hd_tongtien' => $tongTien]);
            DB::commit(); // hoàn tất transaction
            return response()->json([
                'message' => 'Tạo đơn hàng thành công',
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // hủy transaction nếu lỗi

            return response()->json([
                'message' => 'Tạo đơn hàng thất bại',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getHoaDonCuaBan($b_id)
    {
        $hd = QuanLyHoaDon::where('b_id', $b_id)
            ->where('hd_daThanhToan', 0)
            ->with('dsChiTietHoaDon') // eager load chi tiết hóa đơn
            ->first();
        if ($hd) {
            return response()->json([
                'hoadon' => $hd
            ]);
        }
        return response()->json([
            'hoadon' => []
        ]);
    }

    public function thanhToanHoaDon($b_id, Request $request)
    {
        $pttt = $request->input('pttt');
        try {
            DB::beginTransaction(); // bắt đầu transaction
            $hd = QuanLyHoaDon::where('b_id', $b_id)
                ->where('hd_daThanhToan', 0)
                ->first();
            if ($hd) {
                $hd->update(['hd_pttt' => $pttt, 'hd_daThanhToan' => 1]);
                DB::commit(); // hoàn tất transaction
                return response()->json([
                    'message' => 'thanh toán thành công',
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack(); // hủy transaction nếu lỗi

            return response()->json([
                'message' => 'thanh toán thất bại',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
