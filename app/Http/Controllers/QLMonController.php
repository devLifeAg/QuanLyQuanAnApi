<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonAn;
use App\Models\ChiTietHoaDon;
use App\Helpers\MyHelper; // Import helper

class QLMonController
{
    public function store(Request $request)
    {
        $request->validate([
            'pl_id' => 'required|integer',
            'mon_tenmon' => 'required|string|max:50',
            'mon_giamon' => 'required|numeric|min:1000',
            'mon_mota' => 'required|string|max:400',
            'mon_hinhmon' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        try {
            $path = $request->file('mon_hinhmon')->getRealPath();
            $data['mon_hinhmon'] = MyHelper::uploadImage($path, true);
            $monAn = MonAn::create($data);
            return response()->json(['message' => 'Món ăn được thêm thành công!', 'monan' => $monAn], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Lỗi khi upload ảnh',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cập nhật món ăn
     */
    public function update(Request $request, $id)
    {
        // Tìm món ăn theo ID
        $monAn = MonAn::find($id);
        if (!$monAn) {
            return response()->json([
                'message' => 'Không tìm thấy món ăn'
            ], 404);
        }

        // Validate dữ liệu
        $validatedData = $request->validate([
            'pl_id' => 'required|integer',
            'mon_tenmon' => 'required|string|max:50',
            'mon_giamon' => 'required|numeric|min:1000',
            'mon_mota' => 'required|string|max:400',
            'mon_hinhmon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ảnh là tùy chọn
        ]);

        try {
            // Nếu có file ảnh mới được gửi lên
            if ($request->hasFile('mon_hinhmon')) {
                // Xóa ảnh cũ trên Cloudinary (nếu có)
                if ($monAn->mon_hinhmon) {
                    MyHelper::deleteImage($monAn->mon_hinhmon, true);
                }

                // Cập nhật URL ảnh mới vào dữ liệu
                $path = $request->file('mon_hinhmon')->getRealPath();
                $validatedData['mon_hinhmon'] = MyHelper::uploadImage($path, true);
            }

            // Cập nhật thông tin món ăn
            $monAn->update($validatedData);

            return response()->json([
                'message' => 'Cập nhật món ăn thành công!',
                'monan' => $monAn
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Lỗi khi cập nhật món ăn',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa món ăn (kiểm tra ràng buộc với ChiTietHoaDon)
     */
    public function destroy($id)
    {
        // Tìm món ăn theo ID
        $monAn = MonAn::find($id);
        if (!$monAn) {
            return response()->json([
                'message' => 'Không tìm thấy món ăn'
            ], 404);
        }

        // Kiểm tra nếu món ăn đã tồn tại trong bảng ChiTietHoaDon
        if (ChiTietHoaDon::where('mon_id', $id)->exists()) {
            return response()->json(['message' => 'Không thể xóa! Món ăn đang được sử dụng trong hóa đơn.'], 400);
        }

        try {
            // Xóa ảnh cũ trên Cloudinary (nếu có)
            if ($monAn->mon_hinhmon) {
                MyHelper::deleteImage($monAn->mon_hinhmon, true);

                $monAn->delete();
                return response()->json(['message' => 'Xóa món ăn thành công!']);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Lỗi khi xóa món ăn',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tắt món ăn (cập nhật trạng thái thành 0)
     */
    public function tatMoMon($id)
    {
        $monAn = MonAn::findOrFail($id);
        $monAn->update(['mon_trangthai' => $monAn->mon_trangthai == 0 ? 1 : 0]);
        $kq = $monAn->mon_trangthai == 1 ? 'Món ăn đã được mở' : 'Món ăn đã được tắt';
        return response()->json(['message' => $kq]);
    }
}
