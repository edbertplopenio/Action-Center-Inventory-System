<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // If you want to add back the status column (if needed), use the following:
        // Schema::table('users', function (Blueprint $table) {
        //     $table->string('status')->default('active');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if the 'status' column exists before attempting to drop it
            if (Schema::hasColumn('users', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
