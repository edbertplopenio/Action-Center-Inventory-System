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
        Schema::table('items', function (Blueprint $table) {
            // Add a boolean column for consumable with default value of false
            $table->boolean('is_consumable')->default(false); // Adjust the position as needed
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            // Drop the consumable column when rolling back the migration
            $table->dropColumn('is_consumable');
        });
    }
};
