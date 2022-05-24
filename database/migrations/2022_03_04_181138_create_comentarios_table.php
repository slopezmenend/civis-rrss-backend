<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('comentarios')->onDelete('cascade');
            $table->string('titulo')->default('');
            $table->text('text')->nullable();
            $table->string('enlace')->default('');
            $table->string('image')->default('');
            $table->string('alt')->default('');
            $table->string('video')->default('');
            $table->string('subs')->default('');
            $table->bigInteger('encanta')->default(0);
            $table->bigInteger('gusta')->default(0);
            $table->bigInteger('igual')->default(0);
            $table->bigInteger('disgusta')->default(0);
            $table->bigInteger('odia')->default(0);
            $table->bigInteger('ncomentarios')->default(0);
            $table->bigInteger('idcivis')->default(0);
            $table->string('tipo_civis')->default('');
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
        Schema::dropIfExists('follows');
    }
}

