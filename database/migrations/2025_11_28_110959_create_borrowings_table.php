<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('borrower_name');
            $table->string('borrower_phone')->nullable();

            $table->date('borrowed_at')->useCurrent();                 // hozirgi sana
            $table->date('due_date');                                  // masalan +14 kun
            $table->date('returned_at')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('due_date');
            $table->index('returned_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};