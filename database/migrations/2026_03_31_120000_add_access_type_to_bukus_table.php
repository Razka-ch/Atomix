<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
  public function up(): void
  {
    Schema::table('bukus', function (Blueprint $table) {
      $table->string('access_type', 20)->default('free')->after('kategori');
    });

    DB::table('bukus')
      ->whereNotNull('pdf_file')
      ->update(['access_type' => 'member']);
  }

  public function down(): void
  {
    Schema::table('bukus', function (Blueprint $table) {
      $table->dropColumn('access_type');
    });
  }
};
