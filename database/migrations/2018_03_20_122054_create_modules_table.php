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
            $table->uuid('id');
            $table->primary('id');
            $table->string('title');
            $table->string('name');
            $table->string('category');
            $table->string('logo_url');
            $table->string('repository');
            $table->text('description');
            $table->uuid('publisher_id');
            $table->foreign('publisher_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('module_versions', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('commit');
            $table->string('version');
            $table->text('changelog');
            $table->uuid('module_id');
            $table->foreign('module_id')->references('id')->on('modules');
            $table->timestamps();
        });

        Schema::create('module_screenshots', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('screen_url');
            $table->uuid('module_id')->references('id')->on('modules');
            $table->timestamps();
        });

        Schema::create('mirror_modules', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('module_id');
            $table->uuid('link_id');
            $table->json('settings')->nullable();
            $table->foreign('module_id')->references('id')->on('module_versions');
            $table->foreign('link_id')->references('id')->on('user_mirrors');
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
        Schema::dropIfExists('mirror_modules');
        Schema::dropIfExists('module_versions');
        Schema::dropIfExists('modules');
    }
}
