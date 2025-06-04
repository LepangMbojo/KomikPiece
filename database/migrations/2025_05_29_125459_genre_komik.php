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
        Schema::create('komik_genre', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('komik_id'); // Sesuaikan dengan nama tabel komik Anda
            $table->unsignedBigInteger('genre_id');
            $table->timestamps();
            
            // Jika tabel komik Anda bernama 'komiks'
            $table->foreign('komik_id')->references('id')->on('komiks')->onDelete('cascade');
            $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
            
            $table->unique(['komik_id', 'genre_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komik_genre');
    }   
};
