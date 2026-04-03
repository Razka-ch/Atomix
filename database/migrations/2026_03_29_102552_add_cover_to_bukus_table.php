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
    Schema::table('bukus', function (Blueprint $table) {
        // Kita selipkan setelah kolom 'stok' biar rapi
        $table->string('cover')->nullable()->after('stok');
    });
}

public function down(): void
{
    Schema::table('bukus', function (Blueprint $table) {
        $table->dropColumn('cover');
    });
}
};
