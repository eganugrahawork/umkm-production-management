<?php

namespace Database\Seeders;

use App\Models\CustomerType;
use Illuminate\Database\Seeder;

class CustomerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomerType::create([
            'name' => 'Tokopedia',
            'status' => '1'
        ]);
        CustomerType::create([
            'name' => 'Tiktok',
            'status' => '1'
        ]);
        CustomerType::create([
            'name' => 'Shopee',
            'status' => '1'
        ]);
    }
}
