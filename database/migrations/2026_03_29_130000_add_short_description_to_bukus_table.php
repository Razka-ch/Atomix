<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::table('bukus', function (Blueprint $table) {
      $table->text('deskripsi_singkat')->nullable()->after('pdf_file');
    });
  }

  public function down(): void
  {
    Schema::table('bukus', function (Blueprint $table) {
      $table->dropColumn('deskripsi_singkat');
    });
  }
};
