<?php

namespace App\Helpers;

use Cloudinary\Api\Upload\UploadApi;

class MyHelper
{
    public static function deleteImage($url, $isAnhMon)
    {
        if (!$url || !is_string($url)) {
            return null; // Trả về null nếu URL không hợp lệ
        }

        $parts = explode('/', $url);
        $fileName = end($parts); // Lấy phần cuối (tên file)
        $publicId = str_replace('.' . pathinfo($fileName, PATHINFO_EXTENSION), '', $fileName); // Xóa đuôi file
        $folder = $isAnhMon ? 'anh_mon/' : 'anh_phan_loai/'; // Thư mục đã dùng khi upload
        $fullPublicId = $folder . $publicId; // Đường dẫn đầy đủ của ảnh trên Cloudinary

        $uploadApi = new UploadApi();
        $uploadApi->destroy($fullPublicId);
    }

    public static function uploadImageSeed($imageName, $isAnhMon)
    {
        $path = $isAnhMon ? 'anh_mon/' : 'anh_phan_loai/';
        // Tạo đường dẫn đầy đủ từ thư mục public
        $fullPath = public_path($path . $imageName);

        // Kiểm tra xem file có tồn tại không
        if (!file_exists($fullPath)) {
            throw new \Exception("File ảnh không tồn tại: $fullPath");
        }

        try {
            return self::uploadImage($fullPath, $isAnhMon);
        } catch (\Exception $e) {
            throw new \Exception("Lỗi khi upload ảnh lên Cloudinary: " . $e->getMessage());
        }
    }

    public static function uploadImage($path, $isAnhMon)
    {
        $uploadApi = new UploadApi();
        // Upload ảnh lên Cloudinary
        $nameType = $isAnhMon ? 'mon_' : 'pl_';
        $uploadedFile = $uploadApi->upload($path, [
            'folder' => $isAnhMon ? 'anh_mon' : 'anh_phan_loai',
            'public_id' => $nameType . time(), // Đảm bảo tên duy nhất
        ]);

        // Trả về public_id thay vì secure_url
        return $uploadedFile['secure_url'];
    }
}
