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
Schema::create('komik_user', function (Blueprint $table) {
    $table->id();
    $table->integer('count')->default(0); // Jumlah komik yang difavoritkan
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('komik_fav_id')->constrained('komiks')->onDelete('cascade');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komik_user');
    }
};
