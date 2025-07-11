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
        Schema::create('tasklists', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')
            ->nullable()
            ->constrained()
            ->cascadeOnUpdate();
            $table->uuid('projek_id')
            ->nullable()
            ->constrained()
            ->cascadeOnUpdate();
            $table->string('name');
            $table->date('tanggal');
            $table->enum('status', ['In Progres', 'Pending', 'Completed'])->default('Pending');
            $table->json('files')->nullable();  // Stores multiple file paths
            $table->json('file_links')->nullable(); // Stores multiple links
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasklists');
    }
};
