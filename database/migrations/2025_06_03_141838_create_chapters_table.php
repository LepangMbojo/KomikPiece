<?php
// database/migrations/xxxx_xx_xx_create_chapters_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('komik_id')->constrained('komiks')->onDelete('cascade');
            $table->integer('chapter_number');
            $table->string('title')->nullable();
            $table->json('pages')->nullable(); // Array path gambar halaman
            $table->integer('views')->default(0);
            $table->timestamps();
            
            $table->unique(['komik_id', 'chapter_number']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('chapters');
    }
};