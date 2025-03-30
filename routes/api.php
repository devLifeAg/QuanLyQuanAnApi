<?php

use App\Http\Controllers\KetCaController;
use App\Http\Controllers\QLBanController;
use App\Http\Controllers\QLMonController;
use App\Http\Controllers\QLPhanLoaiController;
use App\Http\Controllers\QLTaiKhoanController;
use App\Http\Controllers\QLTangController;
use App\Http\Controllers\QLHoaDonController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Tang;
use App\Models\PhanLoaiMonAn;
use App\Models\MonAn;
use App\Http\Controllers\QuanLyKetCaController;


// API đăng nhập
Route::post('/login', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');

    $user = User::where('u_username', $username)->first();

    if ($user && Hash::check($password, $user->u_pass)) {
        return response()->json([
            'result' => 1,
            'user' => [
                'u_id' => $user->u_id,
                'u_username' => $user->u_username,
                'u_name' => $user->u_name,
                'u_role' => $user->u_role,
            ]
        ]);
    } else {
        return response()->json(['result' => 0]);
    }
});

// API trả về danh sách tầng và bàn
Route::get('/tangvaban', function () {
    $data = Tang::with('danhsachban')->get();
    return response()->json([
        'result' => 1,
        'tang' => $data
    ]);
});

// API trả về danh sách phân loại và món ăn
Route::get('/phanloaivamonan', function () {
    $data = PhanLoaiMonAn::with('monan')->get();
    return response()->json([
        'result' => 1,
        'phanloai' => $data
    ]);
});

// API trả về danh sách món ăn
Route::get('/danhsachmonan', function () {
    $data = MonAn::all();
    return response()->json([
        'result' => 1,
        'monan' => $data
    ]);
});


//QLMA
Route::post('/themmonan', [QLMonController::class, 'store']);
Route::put('/suamonan/{id}', [QLMonController::class, 'update']);
Route::delete('/xoamonan/{id}', [QLMonController::class, 'destroy']);
Route::put('/tatmomon/{id}', [QLMonController::class, 'tatMoMon']);

//QLPL
Route::post('/themphanloai', [QLPhanLoaiController::class, 'store']);
Route::put('/suaphanloai/{id}', [QLPhanLoaiController::class, 'update']);
Route::delete('/xoaphanloai/{id}', [QLPhanLoaiController::class, 'destroy']);

//QLTầng
Route::post('/themtang', [QLTangController::class, 'store']);
Route::put('/suatang/{id}', [QLTangController::class, 'update']);
Route::delete('/xoatang/{id}', [QLTangController::class, 'destroy']);
Route::put('/tatmotang/{id}', [QLTangController::class, 'tatMoTang']);

//QLBàn
Route::post('/themban', [QLBanController::class, 'store']);
Route::put('/suaban/{id}', [QLBanController::class, 'update']);
Route::delete('/xoaban/{id}', [QLBanController::class, 'destroy']);
Route::put('/tatmoban/{id}', [QLBanController::class, 'tatMoBan']);

//QLHoaDon
Route::prefix('hoadon')->group(function () {
    Route::post('/them', [QLHoaDonController::class, 'themHoaDon']);              // Thêm hóa đơn
    Route::put('/sua/{hd_id}', [QLHoaDonController::class, 'suaHoaDon']);          // Sửa hóa đơn
    Route::delete('/xoa/{hd_id}', [QLHoaDonController::class, 'xoaHoaDon']);       // Xóa hóa đơn
    Route::post('/thanhtoan/{hd_id}', [QLHoaDonController::class, 'thanhToanHoaDon']); // Thanh toán hóa đơn
});
//QLChiTietHoaDon
Route::prefix('chitiethoadon')->group(function () {
    Route::post('/them', [QLHoaDonController::class, 'themChiTietHoaDon']);        // Thêm chi tiết hóa đơn
    Route::put('/sua/{ct_id}', [QLHoaDonController::class, 'suaChiTietHoaDon']);   // Sửa chi tiết hóa đơn
    Route::delete('/xoa/{ct_id}', [QLHoaDonController::class, 'xoaChiTietHoaDon']); // Xóa chi tiết hóa đơn
});
//Doanhthu
Route::get('/doanhthu', [QuanLyKetCaController::class, 'getDoanhThu']);



//QLKếtCa
Route::get('/previewketca', [KetCaController::class, 'xemPreviewKetCa']);
Route::post('/taoketca/{id}', [KetCaController::class, 'taoKetCa']);
Route::get('/danhsachketca', [KetCaController::class, 'getDSKetCa']);
Route::get('/danhsachhoadon/{id}', [KetCaController::class, 'getHoaDonOfKetCa']);

//QLTàiKhoanr
Route::get('/danhsachtaikhoan', [QLTaiKhoanController::class, 'getDanhSachTaiKhoan']);
Route::post('/taotaikhoan', [QLTaiKhoanController::class, 'store']);
Route::put('/suataikhoan/{id}', [QLTaiKhoanController::class, 'update']);
Route::delete('/xoataikhoan/{id}', [QLTaiKhoanController::class, 'destroy']);