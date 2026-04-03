<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->date('membership_started_at')->nullable()->after('role');
      $table->date('membership_ends_at')->nullable()->after('membership_started_at');
    });
  }

  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn(['membership_started_at', 'membership_ends_at']);
    });
  }
};
