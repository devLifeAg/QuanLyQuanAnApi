<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ban;

class BanSeeder extends Seeder
{
    public function run()
    {
        Ban::insert([
            ['b_tenban' => 'Bàn 1', 't_id' => 1],
            ['b_tenban' => 'Bàn 2', 't_id' => 1],
            ['b_tenban' => 'Bàn 3', 't_id' => 1],
            ['b_tenban' => 'Bàn 4', 't_id' => 1],
            ['b_tenban' => 'Bàn 5', 't_id' => 2],
            ['b_tenban' => 'Bàn 6', 't_id' => 2],
            ['b_tenban' => 'Bàn 7', 't_id' => 2],
            ['b_tenban' => 'Bàn 8', 't_id' => 2],
        ]);
    }
}
