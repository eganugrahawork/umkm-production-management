<?php

namespace Database\Seeders;

use App\Models\MenuAccess;
use Illuminate\Database\Seeder;

class MenuAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MenuAccess::create([
            'role_id' => 1,
            'menu_id'=> 1
        ]);
        MenuAccess::create([
            'role_id' => 1,
            'menu_id'=> 2
        ]);
        MenuAccess::create([
            'role_id' => 1,
            'menu_id'=> 3
        ]);
        MenuAccess::create([
            'role_id' => 1,
            'menu_id'=> 4,
            'created'=> 1,
            'updated'=> 1,
            'deleted'=> 1
        ]);
        MenuAccess::create([
            'role_id' => 1,
            'menu_id'=> 5,
            'created'=> 1,
            'updated'=> 1,
            'deleted'=> 1
        ]);
        MenuAccess::create([
            'role_id' => 1,
            'menu_id'=> 6,
            'created'=> 1,
            'updated'=> 1,
            'deleted'=> 1
        ]);
        MenuAccess::create([
            'role_id' => 1,
            'menu_id'=> 7,
            'created'=> 1,
            'updated'=> 1,
            'deleted'=> 1
        ]);
        MenuAccess::create([
            'role_id' => 1,
            'menu_id'=> 8,
            'created'=> 1,
            'updated'=> 1,
            'deleted'=> 1
        ]);
        MenuAccess::create([
            'role_id' => 1,
            'menu_id'=> 9,
            'created'=> 1,
            'updated'=> 1,
            'deleted'=> 1
        ]);
        MenuAccess::create([
            'role_id' => 1,
            'menu_id'=> 10,
            'created'=> 1,
            'updated'=> 1,
            'deleted'=> 1
        ]);
        MenuAccess::create([
            'role_id' => 1,
            'menu_id'=> 11,
            'created'=> 1,
            'updated'=> 1,
            'deleted'=> 1
        ]);
        MenuAccess::create([
            'role_id' => 1,
            'menu_id'=> 12,
            'created'=> 1,
            'updated'=> 1,
            'deleted'=> 1
        ]);
        MenuAccess::create([
            'role_id' => 1,
            'menu_id'=> 13,
            'created'=> 1,
            'updated'=> 1,
            'deleted'=> 1
        ]);
    }
}
