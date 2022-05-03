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
        Schema::create('locateds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imsi_id')->constrained('imsis')->onDelete('cascade');
            $table->foreignId('timsi_id')->constrained('timsis')->onDelete('cascade');
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
        Schema::dropIfExists('locateds');
    }
};
