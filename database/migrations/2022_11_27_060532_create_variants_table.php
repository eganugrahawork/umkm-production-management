<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id');
            $table->integer('parent')->default(0);
            $table->string('name')->default('-');
            $table->double('qty_receive')->default(0);
            $table->double('total_receive')->default(0);
            $table->double('qty_sales')->default(0);
            $table->double('total_sales')->default(0);
            $table->integer('status')->default(1);
            $table->integer('have_variant')->default(1)->comment('0 is not have, 1 is have');
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
        Schema::dropIfExists('variants');
    }
}
