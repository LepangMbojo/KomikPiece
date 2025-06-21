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
            $table->text('description')->nullable();
            $table->string('author')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table->dropColumn('genre');
        Schema::dropIfExists('komiks');
    }
};
