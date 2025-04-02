<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
// migration file
public function up()
{
    Schema::create('borrowed_item_individual_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('borrowed_item_id')->constrained('borrowed_items')->onDelete('cascade');
        $table->foreignId('individual_item_id')->constrained('individual_items')->onDelete('cascade');
        $table->timestamps();
    });
}

};
