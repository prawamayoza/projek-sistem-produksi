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
        Schema::create('history_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')
            ->nullable()
            ->constrained()
            ->cascadeOnUpdate();
            $table->uuid('tasklist_id')
            ->nullable()
            ->constrained()
            ->cascadeOnUpdate();
            $table->enum('status', ['Projek Berjalan', 'Projek Selesai'])->default('Projek Berjalan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_users');
    }
};
