<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tang;

class TangSeeder extends Seeder
{
    public function run()
    {
        Tang::insert([
            ['t_tentang' => 'Tầng 1'],
            ['t_tentang' => 'Tầng 2'],
        ]);
    }
}
