<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhanLoaiMonAn extends Model
{
    use HasFactory;

    protected $table = 'phanloaimonan'; // Tên bảng trong database
    protected $primaryKey = 'pl_id'; // Khóa chính
    public $timestamps = false; // Không sử dụng timestamps

    protected $fillable = [
        'pl_tenpl',
        'pl_tenhinh'
    ];

    /**
     * Quan hệ 1-n với bảng MonAn (1 loại món ăn có nhiều món)
     */
    public function monan()
    {
        return $this->hasMany(MonAn::class, 'pl_id', 'pl_id');
    }
}
