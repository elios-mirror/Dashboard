<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateMirrorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();

        Schema::create('mirrors', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('short_id')->unique();
            $table->string('name')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->string('model');
            $table->foreign('model')->references('id')->on('mirror_models');
            $table->timestamps();
        });

        Schema::create('user_mirrors', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('mirror_id');
            $table->uuid('user_id');
            $table->foreign('mirror_id')->references('id')->on('mirrors')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::disableForeignKeyConstraints();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_mirrors');
        Schema::dropIfExists('mirrors');
    }
}
