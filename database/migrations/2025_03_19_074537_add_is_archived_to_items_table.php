<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->boolean('is_archived')->default(false); // Default is false (not archived)
        });
    }
    
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('is_archived');
        });
    }
};
