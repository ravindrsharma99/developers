<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_apps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid')->default('0');
            $table->string('file');
            $table->string('version_number')->nullable();
            $table->string('category')->nullable();
            $table->string('price')->nullable();
            $table->string('amount')->nullable();
            $table->string('support_email')->nullable();
            $table->string('app_name')->nullable();
            $table->string('company')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('description')->nullable();
            $table->integer('terms_agree')->default('0');
            $table->integer('rate')->nullable();
            $table->string('step');
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new_apps');
    }
}
