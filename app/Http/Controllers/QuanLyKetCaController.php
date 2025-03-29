<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuanLyKetCa;

class QuanLyKetCaController extends Controller
{
    public function getDoanhThu(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $result = QuanLyKetCa::whereBetween('kc_ngaygio', [$startDate, $endDate])
            ->selectRaw('SUM(kc_tongtien) as total_tongtien, SUM(kc_sl_hd) as total_sl_hd')
            ->first();

        return response()->json([
            'total_tongtien' => $result->total_tongtien ?? 0,
            'total_sl_hd' => $result->total_sl_hd ?? 0,
        ]);
    }
}
