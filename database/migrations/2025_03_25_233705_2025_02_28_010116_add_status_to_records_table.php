<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('records', function (Blueprint $table) {
            // Check if 'status' column exists before trying to add it
            if (!Schema::hasColumn('records', 'status')) {
                $table->string('status')->default('active'); // Add the column only if it doesn't exist
            }
        });
    }

    public function down()
    {
        Schema::table('records', function (Blueprint $table) {
            $table->dropColumn('status'); // Drop the column if needed
        });
    }
};
