<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('borrowed_equipment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('borrower_id');
            $table->unsignedBigInteger('item_id');
            $table->integer('quantity_borrowed');
            $table->timestamp('borrow_date')->useCurrent();
            $table->date('due_date');
            $table->date('return_date')->nullable();
            $table->enum('status', [
                'Pending', 'Approved', 'Rejected', 'Borrowed', 'Returned', 'Overdue', 'Lost', 'Damaged'
            ])->default('Pending');
            $table->string('responsible_person', 200);
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->boolean('is_archived')->default(false);

            // Indexes
            $table->index('borrower_id');
            $table->index('item_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowed_equipment');
    }
};
