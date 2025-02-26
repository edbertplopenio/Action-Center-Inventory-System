<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Force InnoDB engine

            $table->id();
            $table->string('name');
            $table->string('email', 191)->unique(); // Reduce length to 191
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('department'); // Add department column
            $table->string('cellphone_number'); // Add cellphone_number column
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Force InnoDB engine

            $table->string('email', 191)->primary(); // Reduce length to 191
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Force InnoDB engine

            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
