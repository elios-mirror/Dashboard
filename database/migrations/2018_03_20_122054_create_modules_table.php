<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
            $table->uuid('id')->default(DB::raw('uuid_generate_v4()'));
            $table->primary('id');
            $table->string('name');
            $table->string('repo');
            $table->string('commit');
            $table->uuid('publisher_id');
            $table->foreign('publisher_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('user_modules', function (Blueprint $table) {
            DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
            $table->uuid('module_id');
            $table->uuid('user_id');
            $table->foreign('module_id')->references('id')->on('modules');
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
        Schema::dropIfExists('modules');
        Schema::dropIfExists('user_modules');
    }
}
