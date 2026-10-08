<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lila_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('value_cm', 4, 1);
            $table->date('measured_at');
            $table->timestamps();

            $table->index(['user_id', 'measured_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lila_measurements');
    }
};
