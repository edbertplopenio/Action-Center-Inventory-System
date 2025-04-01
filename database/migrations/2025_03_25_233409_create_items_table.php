<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();  // Primary Key
            $table->string('name');  // Column for item name
            $table->string('item_code');  // Column for item code
            $table->string('category');  // Column for item category
            $table->integer('quantity');  // Column for quantity
            $table->string('unit');  // Column for unit of measurement
            $table->text('description');  // Column for item description
            $table->string('storage_location');  // Column for storage location
            $table->date('arrival_date');  // Column for arrival date
            $table->date('date_purchased');  // Column for date purchased
            $table->enum('status', ['active', 'inactive']);  // Column for status
            $table->string('image_url')->nullable();  // Column for image URL
            $table->timestamps();  // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
