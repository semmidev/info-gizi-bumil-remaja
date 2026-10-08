<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['pengetahuan', 'sikap', 'tindakan']);
            $table->string('indicator')->nullable();
            $table->text('text');
            $table->unsignedSmallInteger('position');
            $table->string('aspect')->nullable();
            $table->boolean('is_favorable')->nullable();
            $table->text('good_feedback')->nullable();
            $table->text('bad_feedback')->nullable();
            $table->text('explanation')->nullable();
            $table->text('tip')->nullable();
            $table->timestamps();

            $table->index(['type', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
