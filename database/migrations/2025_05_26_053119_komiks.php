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
        Schema::create('komiks', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('cover')->nullable();
            $table->integer('rating')->nullable();
            $table->integer('chapter')->nullable();
            $table->string('status')->nullable();
            $table->string('language')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('author')->nullable();
            $table->integer('Favorite')->default(0);
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
