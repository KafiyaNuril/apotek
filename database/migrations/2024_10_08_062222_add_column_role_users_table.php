<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * up() akan dijalankan ketika artisan migrate di running
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'cashier']);
        });
    }

    /**
     * Reverse the migrations.
     * down() akan dijalankan ketika artisan migrate:rollback di running
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'cashier']);
        });
    }
};
