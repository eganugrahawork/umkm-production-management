<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variant_options', function (Blueprint $table) {
            $table->id();
            $table->integer('variant_id');
            $table->integer('parent')->default(0);
            $table->string('name')->default('-');
            $table->double('stock')->default(0);
            $table->double('price')->default(0);
            $table->double('qty_receive')->default(0);
            $table->double('total_receive')->default(0);
            $table->double('qty_sales')->default(0);
            $table->double('total_sales')->default(0);
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
        Schema::dropIfExists('variant_options');
    }
}
