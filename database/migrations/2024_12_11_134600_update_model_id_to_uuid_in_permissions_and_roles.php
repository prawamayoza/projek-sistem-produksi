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
         // Ubah tipe data model_id di tabel model_has_roles
         Schema::table('model_has_roles', function (Blueprint $table) {
            $table->uuid('model_id')->change(); // Ubah ke UUID
        });

        // Ubah tipe data model_id di tabel model_has_permissions
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->uuid('model_id')->change(); // Ubah ke UUID
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
                // Kembalikan tipe data ke BIGINT
                Schema::table('model_has_roles', function (Blueprint $table) {
                    $table->bigInteger('model_id')->unsigned()->change();
                });
        
                Schema::table('model_has_permissions', function (Blueprint $table) {
                    $table->bigInteger('model_id')->unsigned()->change();
                });
    }
};
