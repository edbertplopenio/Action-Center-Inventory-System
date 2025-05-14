<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            // Add a boolean column for consumable with default value of false
            $table->boolean('is_consumable')->default(false)->after('expiration_date'); // Ensure it is placed after expiration_date (you can adjust the column order as needed)
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            // Drop the consumable column when rolling back the migration
            $table->dropColumn('is_consumable');
        });
    }
};
