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
       Schema::create('genre_komik', function (Blueprint $table) {
            // Foreign key untuk tabel 'genres'
            $table->foreignId('genre_id')->constrained()->onDelete('cascade');

            // Foreign key untuk tabel 'komiks' (atau apa pun nama tabel komik Anda)
            $table->foreignId('komik_id')->constrained()->onDelete('cascade');

            // Menetapkan composite primary key untuk mencegah duplikasi
            // (satu komik tidak bisa memiliki genre yang sama lebih dari sekali)
            $table->primary(['genre_id', 'komik_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genre_komik');
    }
};
