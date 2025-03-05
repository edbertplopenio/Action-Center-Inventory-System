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
            // Modify 'volume' column to have better precision
            $table->decimal('volume', 10, 6)->nullable()->change();

            // Modify 'medium' column to reduce length
            $table->string('medium', 50)->collation('utf8mb4_unicode_ci')->change();

            // Modify 'restriction' to ENUM for validation
            $table->enum('restriction', ['open-access', 'confidential'])->default('open-access')->change();

            // Modify 'frequency' to ENUM for consistency
            $table->enum('frequency', ['as_needed', 'weekly', 'monthly', 'yearly'])->default('as_needed')->change();

            // Modify 'duplication' to allow a default value
            $table->string('duplication', 191)->nullable()->default('None')->change();

            // Modify 'time_value' to ENUM for better constraints
            $table->enum('time_value', ['T', 'P'])->default('T')->change();

            // Add 'active_unit' and 'storage_unit' for retention period selection
            $table->enum('active_unit', ['years', 'months'])->nullable()->after('active');
            $table->enum('storage_unit', ['years', 'months'])->nullable()->after('storage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('records', function (Blueprint $table) {
            // Rollback changes to original structure
            $table->decimal('volume', 10, 6)->nullable()->change();
            $table->string('medium', 191)->collation('utf8mb4_unicode_ci')->change();
            $table->string('restriction', 191)->collation('utf8mb4_unicode_ci')->change();
            $table->string('frequency', 191)->collation('utf8mb4_unicode_ci')->change();
            $table->string('duplication', 191)->nullable()->change();
            $table->string('time_value', 191)->collation('utf8mb4_unicode_ci')->change();

            // Drop 'active_unit' and 'storage_unit'
            $table->dropColumn(['active_unit', 'storage_unit']);
        });
    }
};
