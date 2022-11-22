<?php

namespace Database\Seeders;

use App\Models\TypePartner;
use Illuminate\Database\Seeder;

class TypePartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypePartner::create([
            'name' => 'Penjahit'
        ]);
        TypePartner::create([
            'name' => 'Supplier'
        ]);


    }
}
