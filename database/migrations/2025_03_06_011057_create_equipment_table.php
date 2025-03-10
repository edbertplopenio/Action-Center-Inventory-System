<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('items', function (Blueprint $table) {
        $table->id();
        $table->string('item_name');
        $table->string('category');
        $table->integer('quantity');
        $table->string('unit');
        $table->text('description');
        $table->date('arrival_date');
        $table->date('date_purchased');
        $table->string('status');
        $table->string('image')->nullable(); // Assuming you will store the file path for the image
        $table->string('storage_location');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
