<?php
// database/migrations/xxxx_xx_xx_update_komiks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('komiks', function (Blueprint $table) {
            // Tambahkan kolom slug jika belum ada
            if (!Schema::hasColumn('komiks', 'slug')) {
                $table->string('slug')->nullable()->after('judul');
            }
            
            // Tambahkan kolom views jika belum ada
            if (!Schema::hasColumn('komiks', 'views')) {
                $table->integer('views')->default(0)->after('Favorite');
            }
            
            // Tambahkan kolom release_year jika belum ada
            if (!Schema::hasColumn('komiks', 'release_year')) {
                $table->year('release_year')->nullable()->after('author');
            }
        });
    }

    public function down()
    {
        Schema::table('komiks', function (Blueprint $table) {
            $table->dropColumn(['slug', 'views', 'release_year']);
        });
    }
};