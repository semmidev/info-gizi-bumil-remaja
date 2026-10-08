<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('full_name')->nullable()->after('username');
            $table->unsignedTinyInteger('age')->nullable()->after('full_name');
            $table->text('address')->nullable()->after('age');
            $table->unsignedTinyInteger('pregnancy_month')->nullable()->after('address');
            $table->timestamp('last_login_at')->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['full_name', 'age', 'address', 'pregnancy_month', 'last_login_at']);
        });
    }
};
