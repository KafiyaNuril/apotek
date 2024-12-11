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
        // pembuatan schema database
        Schema::create('medicines', function (Blueprint $table) {
            // menentukan tipe data pada attribute
            $table->id(); //primary key
            $table->enum('type', ['tablet', 'sirup', 'kapsul']);
            $table->string('name');
            $table->string('price');
            $table->string('stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * buat mengembalikan nilai yang sebelumnya udah ada
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
