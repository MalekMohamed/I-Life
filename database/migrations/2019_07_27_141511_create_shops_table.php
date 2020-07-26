<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category');
            $table->string('name')->unique();
            $table->integer('price');
            $table->string('color')->default('white');
            $table->longText('description')->nullable();
            $table->longText('specification')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('status')->default(0);
            $table->string('images')->nullable()->default('default.jpg');
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
        //
    }
}
