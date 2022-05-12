<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sceneries', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->timestamp('start');
            $table->timestamp('finish')->nullable();
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
        Schema::dropIfExists('sceneries');
    }
};
