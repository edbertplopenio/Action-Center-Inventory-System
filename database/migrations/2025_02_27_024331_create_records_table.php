<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('records', function (Blueprint $table) { // Use create() instead of table()
            $table->id();
            $table->string('title');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('volume', 10, 6)->nullable(); // Storing precise decimal values
            $table->string('medium');
            $table->string('restriction');
            $table->string('location');
            $table->string('frequency');
            $table->string('duplication')->nullable();
            $table->string('time_value');
            $table->string('utility_value')->nullable();
            $table->integer('active')->nullable();
            $table->integer('storage')->nullable();
            $table->integer('total')->nullable();
            $table->text('disposition')->nullable();
            $table->timestamps(); // Important: Adds created_at & updated_at fields
        });
    }

    public function down() {
        Schema::dropIfExists('records'); // Properly reverse migration
    }
};
