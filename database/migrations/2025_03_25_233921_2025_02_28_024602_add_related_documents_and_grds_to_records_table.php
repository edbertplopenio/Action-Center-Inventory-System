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
            // Check if 'title' column exists before adding 'related_documents'
            if (Schema::hasColumn('records', 'title')) {
                $table->string('related_documents', 191)->nullable()->after('title');
            } else {
                // Add 'related_documents' column at the end if 'title' column is missing
                $table->string('related_documents', 191)->nullable();
            }

            // Check if 'grds' column exists before adding it
            if (!Schema::hasColumn('records', 'grds')) {
                $table->text('grds')->nullable(); // Example for adding grds column if missing
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('records', function (Blueprint $table) {
            // Drop 'related_documents' and 'grds' columns if they exist
            $table->dropColumn(['related_documents', 'grds']);
        });
    }
};
