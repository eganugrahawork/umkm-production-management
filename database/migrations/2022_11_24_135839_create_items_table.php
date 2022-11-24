<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->integer('category_id');
            $table->integer('stock')->default(0);
            // $table->integer('cogs')->default(0)->comment('Harga Pokok'); // nanti dimasukin di varian, kalau tidak ada varian keterangan divariannya 0 tapi haranya dimasukin
            $table->integer('qty_sales')->default(0);
            $table->integer('total_sales')->default(0);
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
