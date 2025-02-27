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
        Schema::table('users', function (Blueprint $table) {
            $table->string('department')->nullable(); // New field for department
            $table->string('cellphone_number')->nullable(); // New field for cellphone number
            // Add any other fields if needed, e.g., $table->string('another_field')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['department', 'cellphone_number']);
            // If you added other fields, make sure to drop them here as well
        });
    }
};