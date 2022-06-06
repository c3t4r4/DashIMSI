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
        Schema::table('sceneries', function (Blueprint $table) {
            $table->timestamp('start_local')->nullable();
            $table->timestamp('finish_local')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sceneries', function (Blueprint $table) {
            $table->dropColumn('start_local');
            $table->dropColumn('finish_local');
        });
    }
};
