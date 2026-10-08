<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_target_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('log_date');
            $table->foreignId('checklist_item_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_done')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'log_date', 'checklist_item_id'], 'daily_target_logs_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_target_logs');
    }
};
