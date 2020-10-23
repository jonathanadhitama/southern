<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeHeightAndMassToDecimalsForSwapiCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('swapi_characters', function (Blueprint $table) {
            $table->decimal('height')->nullable()->change();
            $table->decimal('mass')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('swapi_characters', function (Blueprint $table) {
            $table->string('mass')->nullable()->change();
            $table->string('hair_colour')->nullable()->change();
        });
    }
}
