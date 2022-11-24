<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::create([
            'parent' => 0,
            'name' => 'Dashboard',
            'url'=> '/admin/dashboard',
            'icon'=> '-',
            'status'=> 1
        ]);
        Menu::create([
            'parent' => 0,
            'name' => 'Users',
            'url'=> '/admin/users',
            'icon'=> '-',
            'status'=> 1
        ]);
        Menu::create([
            'parent' => 0,
            'name' => 'Master Data',
            'url'=> '/admin/masterdata',
            'icon'=> '-',
            'status'=> 1
        ]);
        Menu::create([
            'parent' => 3,
            'name' => 'Partner',
            'url'=> '/admin/masterdata/partner',
            'icon'=> 'people',
            'status'=> 1
        ]);
        Menu::create([
            'parent' => 4,
            'name' => 'Partner List',
            'url'=> '/admin/masterdata/partner',
            'icon'=> '-',
            'status'=> 1
        ]);
        Menu::create([
            'parent' => 4,
            'name' => 'Type Partner',
            'url'=> '/admin/masterdata/partner/typepartner',
            'icon'=> '-',
            'status'=> 1
        ]);

        Menu::create([
            'parent' => 3,
            'name' => 'Items',
            'url'=> '/admin/masterdata/item',
            'icon'=> 'box',
            'status'=> 1
        ]);

        Menu::create([
            'parent' => 7,
            'name' => 'Item List',
            'url'=> '/admin/masterdata/item',
            'icon'=> '-',
            'status'=> 1
        ]);

        Menu::create([
            'parent' => 7,
            'name' => 'Category',
            'url'=> '/admin/masterdata/item/category',
            'icon'=> '-',
            'status'=> 1
        ]);
    }
}
