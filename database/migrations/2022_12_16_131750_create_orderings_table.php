<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sequence');
            $table->string('begin_code')->default('A');
            $table->string('middle_code')->default('B');
            $table->integer('end_code')->default(0);
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
        Schema::dropIfExists('orderings');
    }
}
