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
        Schema::create('borrowing_slips', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('name');  // Name of the borrower
            $table->string('department');  // Department of the borrower
            $table->string('email');  // Email address of the borrower
            $table->string('responsible_person');  // Responsible person for the borrowing
            $table->string('item_code');  // Code of the item being borrowed
            $table->date('borrow_date');  // Date when the item is borrowed
            $table->integer('quantity');  // Quantity of the item being borrowed
            $table->date('due_date');  // Due date for returning the item
            // Add this to your migration file if not present

$table->string('signature')->nullable();  // For storing file path or signature data

            $table->timestamps();  // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowing_slips');
    }
};
