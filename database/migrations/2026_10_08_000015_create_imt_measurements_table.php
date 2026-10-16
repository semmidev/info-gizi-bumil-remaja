<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imt_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('weight_kg', 5, 1);
            $table->decimal('height_cm', 5, 1);
            $table->decimal('bmi', 4, 1);
            $table->date('measured_at');
            $table->timestamps();

            $table->index(['user_id', 'measured_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imt_measurements');
    }
};
