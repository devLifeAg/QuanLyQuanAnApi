<?php

namespace App\Http\Controllers;

use App\Models\QuanLyHoaDon;
use App\Models\QuanLyKetCa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class QLTaiKhoanController
{
    public function getDanhSachTaiKhoan()
    {
        $users = User::orderBy('u_role', 'asc')->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        // Kiểm tra nếu tên đăng nhập đã tồn tại
        if (User::where('u_username', $request->u_username)->exists()) {
            return response()->json([
                'message' => 'Tên đăng nhập đã tồn tại trong hệ thống!',
            ], 400);
        }
        $validatedData = $request->validate([
            'u_username' => 'required|string|unique:user,u_username|max:30',
            'u_pass' => 'required|string|max:30',
            'u_role' => 'required|integer',
            'u_name' => 'required|string|max:30'
        ]);

        $user = User::create([
            'u_username' => $validatedData['u_username'],
            'u_pass' => Hash::make($validatedData['u_pass']), // Mã hóa mật khẩu
            'u_role' => $validatedData['u_role'],
            'u_name' => $validatedData['u_name']
        ]);

        return response()->json([
            'message' => 'Tạo tài khoản thành công!',
            'user' => $user
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        // Kiểm tra nếu tên đăng nhập đã tồn tại và khác với tài khoản hiện tại
        if ($request->u_username !== $user->u_username) {
            if (User::where('u_username', $request->u_username)->exists()) {
                return response()->json([
                    'message' => 'Tên đăng nhập đã tồn tại trong hệ thống!',
                ], 400);
            }
        }
        // Validation dữ liệu đầu vào
        $validatedData = $request->validate([
            'u_username' => 'sometimes|string|max:30',
            'u_pass' => 'sometimes|string|max:30',
            'u_role' => 'sometimes|integer',
            'u_name' => 'sometimes|string|max:30'
        ]);

        if (isset($validatedData['u_pass'])) {
            $validatedData['u_pass'] = Hash::make($validatedData['u_pass']); // Mã hóa mật khẩu nếu có thay đổi
        }

        $user->update($validatedData);

        return response()->json([
            'message' => 'Cập nhật tài khoản thành công!',
            'user' => $user
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // Kiểm tra xem u_id có tồn tại trong QuanLyKetCa hoặc QuanLyHoaDon không
        $existsInKetCa = QuanLyKetCa::where('u_id', $id)->exists();
        $existsInHoaDon = QuanLyHoaDon::where('u_id', $id)->exists();
        if ($existsInKetCa || $existsInHoaDon) {
            return response()->json([
                'message' => 'Không thể xóa tài khoản vì đang được sử dụng trong hệ thống!',
            ], 400);
        }
        $user->delete();

        return response()->json(['message' => 'Xóa tài khoản thành công!']);
    }
}
