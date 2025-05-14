<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// In the generated migration file
public function up()
{
    Schema::table('items', function (Blueprint $table) {
        $table->dropColumn('date_purchased');
    });
}

public function down()
{
    Schema::table('items', function (Blueprint $table) {
        $table->date('date_purchased')->nullable();
    });
}

};
