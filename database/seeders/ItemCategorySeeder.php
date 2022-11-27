<?php

namespace Database\Seeders;

use App\Models\ItemCategory;
use Illuminate\Database\Seeder;

class ItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ItemCategory::create([
            'name' => 'Pakaian Wanita',
            'status' => '1'
        ]);
        ItemCategory::create([
            'name' => 'Pakaian Pria',
            'status' => '1'
        ]);
        ItemCategory::create([
            'name' => 'Sepatu Wanita',
            'status' => '1'
        ]);
    }
}
