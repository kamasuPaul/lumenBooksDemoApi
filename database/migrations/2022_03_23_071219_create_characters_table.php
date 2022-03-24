<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('gender',['Male','Female'])->nullable();
            $table->string('culture')->nullable();
            $table->json('aliases')->nullable();
            $table->string('url');
            $table->date('born')->nullable();
            $table->date('died')->nullable();
            $table->timestamps();
        });

        //create book_character table to join book and characters
        Schema::create('book_character', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('book_id');
            $table->unsignedBigInteger('character_id');
            $table->foreign('book_id')->references('id')->on('books');
            $table->foreign('character_id')->references('id')->on('characters');
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
        Schema::dropIfExists('characters');
        Schema::dropIfExists('book_character');	
    }
};
