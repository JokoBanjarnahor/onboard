<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShortenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shorten', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->string('shortcode', 6);
            $table->dateTimeTz('startDate');
            $table->dateTimeTz('lastSeenDate');
            $table->integer('redirectCount');
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
        Schema::dropIfExists('shorten');
    }
}
