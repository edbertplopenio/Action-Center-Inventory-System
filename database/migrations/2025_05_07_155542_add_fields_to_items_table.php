<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add new fields to 'items' table
        Schema::table('items', function (Blueprint $table) {
            $table->string('brand')->nullable(); // Brand field
            $table->date('inventory_date')->nullable(); // Inventory Date field
            $table->string('expiration_date')->nullable(); // Expiration Date field for Item
            $table->date('date_tested_inspected')->nullable(); // Date Tested/Inspected field
        });

        // Create a new 'batches' table for storing batches with expiration dates and quantities
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->onDelete('cascade'); // Link to the items table
            $table->integer('quantity'); // Quantity in the batch
            $table->date('expiration_date'); // Expiration date for the batch
            $table->timestamps(); // Timestamp for creation and update
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop 'batches' table
        Schema::dropIfExists('batches');

        // Remove added columns from the 'items' table
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('brand');
            $table->dropColumn('inventory_date');
            $table->dropColumn('expiration_date');
            $table->dropColumn('date_tested_inspected');
        });
    }
}
