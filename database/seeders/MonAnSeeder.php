<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MonAn;

class MonAnSeeder extends Seeder
{
    public function run()
    {
        MonAn::insert([
            ['pl_id' => 1, 'mon_tenmon' => 'Cơm chiên', 'mon_giamon' => 35000, 'mon_mota' => "Cơm chiên dương châu, không cay, có trứng và hải sản.", 'mon_hinhmon' => 'comchien.jpg'],
            ['pl_id' => 1, 'mon_tenmon' => 'Cơm xá xíu', 'mon_giamon' => 40000, 'mon_mota' => 'Cơm xá xíu người hoa ăn ngọt không ngán.', 'mon_hinhmon' => 'comxaxiu.jpg'],
            ['pl_id' => 1, 'mon_tenmon' => 'Cơm gà', 'mon_giamon' => 45000, 'mon_mota' => "Cơm gà góc tư xối mỡ, cơm vàng.", 'mon_hinhmon' => 'comga.jpg'],
            ['pl_id' => 1, 'mon_tenmon' => 'Cơm sườn', 'mon_giamon' => 50000, 'mon_mota' => "Cơm sườn cốt lết, nướng than.", 'mon_hinhmon' => 'comsuon.jpg'],
            ['pl_id' => 2, 'mon_tenmon' => 'Mì xào mềm', 'mon_giamon' => 40000, 'mon_mota' => "Mì xào mềm người hoa thập cẩm có tôm, cật, thịt heo.", 'mon_hinhmon' => 'mixaomem.jpg'],
            ['pl_id' => 2, 'mon_tenmon' => 'Mì xào giòn', 'mon_giamon' => 40000, 'mon_mota' => "Mì xào giòn người hoa thập cẩm có tôm, cật, thịt heo.", 'mon_hinhmon' => 'mixaogion.jpg'],
            ['pl_id' => 2, 'mon_tenmon' => 'Mì thập cẩm', 'mon_giamon' => 45000, 'mon_mota' => "Mì nước thập cẩm có tôm, cật, thịt heo.", 'mon_hinhmon' => 'mithapcam.jpg'],
            ['pl_id' => 2, 'mon_tenmon' => 'Mì hoành thánh', 'mon_giamon' => 50000, 'mon_mota' => 'Mì nước hoành thánh có 6 viên.', 'mon_hinhmon' => 'mihoanhthanh.jpg'],
            ['pl_id' => 3, 'mon_tenmon' => 'Canh củ sen', 'mon_giamon' => 4000, 'mon_mota' => 'Canh tiềm củ sen.', 'mon_hinhmon' => 'canhcusen.jpg'],
            ['pl_id' => 3, 'mon_tenmon' => 'Canh xà lách son', 'mon_giamon' => 40000, 'mon_mota' => 'Cơm tiềm xà lách son.', 'mon_hinhmon' => 'canhxalachson.jpg'],
            ['pl_id' => 3, 'mon_tenmon' => 'Canh rong biển', 'mon_giamon' => 40000, 'mon_mota' => 'Canh rong biển ăn mát người.', 'mon_hinhmon' => 'canhrongbien.jpg'],
            ['pl_id' => 3, 'mon_tenmon' => 'Canh chua', 'mon_giamon' => 40000, 'mon_mota' => "Canh chua có tôm, bạc hà, giá.", 'mon_hinhmon' => 'canhchua.jpg'],
            ['pl_id' => 4, 'mon_tenmon' => 'Chè hột gà', 'mon_giamon' => 30000, 'mon_mota' => 'Hột gà trà người hoa chè ngọt trứng ngon.', 'mon_hinhmon' => 'chehotga.jpg'],
            ['pl_id' => 4, 'mon_tenmon' => 'Chè đậu xanh', 'mon_giamon' => 25000, 'mon_mota' => 'Chè đậu xanh ăn mát người.', 'mon_hinhmon' => 'chedauxanh.jpg'],
            ['pl_id' => 4, 'mon_tenmon' => 'Kem chiên', 'mon_giamon' => 20000, 'mon_mota' => 'Kem chiên ngoài giòn trong mềm lạnh.', 'mon_hinhmon' => 'kemchien.jpg'],
            ['pl_id' => 4, 'mon_tenmon' => 'Rau câu', 'mon_giamon' => 15000, 'mon_mota' => 'Rau câu tráng miệng.', 'mon_hinhmon' => 'raucau.jpg'],
            ['pl_id' => 5, 'mon_tenmon' => 'Trà đá', 'mon_giamon' => 3000, 'mon_mota' => null, 'mon_hinhmon' => 'trada.jpg'], // Không có 'mon_mota'
            ['pl_id' => 5, 'mon_tenmon' => 'Hồng Trà', 'mon_giamon' => 20000, 'mon_mota' => null, 'mon_hinhmon' => 'hongtra.jpg'],
            ['pl_id' => 5, 'mon_tenmon' => '7 up', 'mon_giamon' => 15000, 'mon_mota' => null, 'mon_hinhmon' => '7up.jpg'],
            ['pl_id' => 5, 'mon_tenmon' => 'Pepsi', 'mon_giamon' => 15000, 'mon_mota' => null, 'mon_hinhmon' => 'pepsi.jpg'],
        ]);
    }
}
