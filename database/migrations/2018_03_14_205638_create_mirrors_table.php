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
        Schema::create('mirrors', function (Blueprint $table) {
            DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
            $table->uuid('id')->default(DB::raw('uuid_generate_v4()'));
            $table->primary('id');
            $table->string('name')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->timestamps();
        });

        Schema::create('user_mirrors', function (Blueprint $table) {
            DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
            $table->uuid('mirror_id');
            $table->uuid('user_id');
            $table->foreign('mirror_id')->references('id')->on('mirrors');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mirrors');
        Schema::dropIfExists('user_mirrors');
    }
}
