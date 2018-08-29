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

        Schema::enableForeignKeyConstraints();

        Schema::create('modules', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('uuid_generate_v4()'));
            $table->primary('id');
            $table->string('title');
            $table->string('name');
            $table->string('repository');
            $table->uuid('publisher_id');
            $table->foreign('publisher_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('module_versions', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('uuid_generate_v4()'));
            $table->primary('id');
            $table->string('commit');
            $table->string('version');
            $table->uuid('module_id');
            $table->foreign('module_id')->references('id')->on('modules');
            $table->timestamps();
        });

        Schema::create('user_modules', function (Blueprint $table) {
            $table->uuid('module_id');
            $table->uuid('user_id');
            $table->foreign('module_id')->references('id')->on('module_versions');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('module_versions');
        Schema::dropIfExists('modules');
        Schema::dropIfExists('user_modules');
    }
}
