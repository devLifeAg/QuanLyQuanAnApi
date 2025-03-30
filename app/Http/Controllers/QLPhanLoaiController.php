<?php

namespace App\Http\Controllers;

use App\Models\MonAn;
use App\Models\PhanLoaiMonAn;
use Illuminate\Http\Request;
use App\Helpers\MyHelper; // Import helper

class QLPhanLoaiController
{
    public function store(Request $request)
    {
        $request->validate([
            'pl_tenpl' => 'required|string|max:50',
            'pl_tenhinh' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        try {
            $path = $request->file('pl_tenhinh')->getRealPath();
            $data['pl_tenhinh'] = MyHelper::uploadImage($path, false);
            $pl = PhanLoaiMonAn::create($data);
            return response()->json(['message' => 'Phân loại được thêm thành công!', 'phanloai' => $pl], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Lỗi khi upload ảnh',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $pl = PhanLoaiMonAn::find($id);
        if (!$pl) {
            return response()->json([
                'message' => 'Không tìm thấy phân loại'
            ], 404);
        }

        $validatedData = $request->validate([
            'pl_tenpl' => 'required|string|max:50',
            'pl_tenhinh' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Nếu có file ảnh mới được gửi lên
            if ($request->hasFile('pl_tenhinh')) {
                // Xóa ảnh cũ trên Cloudinary (nếu có)
                if ($pl->pl_tenhinh) {
                    MyHelper::deleteImage($pl->pl_tenhinh, false);
                }

                // Cập nhật URL ảnh mới vào dữ liệu
                $path = $request->file('pl_tenhinh')->getRealPath();
                $validatedData['pl_tenhinh'] = MyHelper::uploadImage($path, false);
            }

            $pl->update($validatedData);

            return response()->json([
                'message' => 'Cập nhật phân loại thành công!',
                'phanloai' => $pl
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Lỗi khi cập nhật phân loại',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $pl = PhanLoaiMonAn::findOrFail($id);
        if (!$pl) {
            return response()->json([
                'message' => 'Không tìm thấy phân loại'
            ], 404);
        }

        if (MonAn::where('pl_id', $id)->exists()) {
            return response()->json(['message' => 'Không thể xóa! Phân loại đã có món ăn'], 400);
        }

        try {
            // Xóa ảnh cũ trên Cloudinary (nếu có)
            if ($pl->pl_tenhinh) {
                MyHelper::deleteImage($pl->pl_tenhinh, false);

                $pl->delete();
                return response()->json(['message' => 'Xóa phân loại thành công!']);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Lỗi khi xóa phân loại',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
