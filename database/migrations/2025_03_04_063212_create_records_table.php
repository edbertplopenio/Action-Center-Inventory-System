<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('documents')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('volume', 100)->nullable();
            $table->string('medium', 100)->nullable();
            $table->string('location', 255)->nullable();
            $table->string('time_value', 100)->nullable();
            $table->string('utility_value', 100)->nullable();
            $table->string('disposition', 255)->nullable();
            $table->string('grds_item', 255)->nullable();
            $table->string('duplication', 255)->nullable();
            $table->text('retention_period')->nullable();
            $table->timestamps(); // Creates 'created_at' and 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
}