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
        Schema::table('records', function (Blueprint $table) {
            // Check if 'active_unit' column exists before adding it
            if (!Schema::hasColumn('records', 'active_unit')) {
                $table->enum('active_unit', ['years', 'months'])->nullable()->after('active');
            }

            // Check if 'storage_unit' column exists before adding it
            if (!Schema::hasColumn('records', 'storage_unit')) {
                $table->enum('storage_unit', ['years', 'months'])->nullable()->after('storage');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('records', function (Blueprint $table) {
            // Drop 'active_unit' and 'storage_unit' columns if they exist
            $table->dropColumn(['active_unit', 'storage_unit']);
        });
    }
};
