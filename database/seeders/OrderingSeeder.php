<?php

namespace Database\Seeders;

use App\Models\Ordering;
use Illuminate\Database\Seeder;

class OrderingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ordering::create([
            'name' => 'Item',
            'sequence' => '0',
            'begin_code' => 'R',
            'middle_code' => 'ITM',
            'end_code' => '0'
        ]);
    }
}
