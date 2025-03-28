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
        Schema::create('individual_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');  // Foreign key to items table
            $table->string('qr_code');  // QR code field
            $table->string('status');  // Status of the individual item
            $table->timestamps();  // Created at and updated at
            $table->boolean('is_archived')->default(false);  // Field for archived status

            // Define the foreign key relationship
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('individual_items');
    }
};
