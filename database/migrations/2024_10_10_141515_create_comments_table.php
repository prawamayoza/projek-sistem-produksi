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
        Schema::create('comments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')
            ->nullable()
            ->constrained()
            ->cascadeOnUpdate();
            $table->uuid('tasklist_id')
            ->nullable()
            ->constrained()
            ->cascadeOnUpdate();
            $table->text('comment');
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
        Schema::dropIfExists('comments');
    }
};
