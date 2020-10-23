<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSWApiCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swapi_characters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('height')->nullable();
            $table->string('mass')->nullable();
            $table->string('hair_colour')->nullable();
            $table->string('birth_year')->nullable();
            $table->string('gender')->nullable();
            $table->string('homeworld')->nullable();
            $table->string('species')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swapi_characters');
    }
}
