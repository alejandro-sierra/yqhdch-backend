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
    // FIXME: Revisar la relacion recursiva, no funciona correctamente
    public function up()
    {
        Schema::create('user_follow', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            
            $table->bigInteger('user_id');
            $table->bigInteger('follow_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_follow');
    }
};
