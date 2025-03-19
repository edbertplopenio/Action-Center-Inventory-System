<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('category');
            $table->integer('quantity');
            $table->string('unit');
            $table->text('description')->nullable();
            $table->string('storage_location');
            $table->date('arrival_date');
            $table->date('date_purchased');
            $table->string('status');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
    }
};
