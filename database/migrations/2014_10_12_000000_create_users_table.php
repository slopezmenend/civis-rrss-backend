<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('fotoperfil')->default('');
            $table->integer('idcivis')->unsigned()->default(0);
            $table->integer('following')->unsigned()->default(0);
            $table->integer('followers')->unsigned()->default(0);
            $table->string('web')->default('');
            $table->string('facebook')->default('');
            $table->string('twitter')->default('');
            $table->string('instagram')->default('');
            $table->string('youtube')->default('');
            $table->string('nombre')->default('');
            $table->string('fotofondo')->default('');
            $table->string('circunscripcion')->default('');
            $table->string('partido')->default('');
            $table->string('grupo')->default('');
            $table->text('biografia')->nullable();
            $table->integer('ideologia')->unsigned()->default(0);
            $table->integer('ideologiaadicional')->unsigned()->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
