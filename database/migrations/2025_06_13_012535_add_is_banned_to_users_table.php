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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom 'is_banned' dengan tipe boolean dan default false
            $table->boolean('is_banned')->default(false)->after('password'); // Anda bisa menentukan posisi setelah kolom mana
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom 'is_banned' jika migrasi di-rollback
            $table->dropColumn('is_banned');
        });
    }
};