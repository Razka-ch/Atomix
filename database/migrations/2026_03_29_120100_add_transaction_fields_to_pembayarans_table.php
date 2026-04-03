<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::table('pembayarans', function (Blueprint $table) {
      $table->string('email')->nullable()->after('user_id');
      $table->string('transaction_id')->nullable()->after('bukti_pembayaran');
      $table->string('payment_channel')->default('dana')->after('transaction_id');
      $table->text('notes')->nullable()->after('payment_channel');
      $table->timestamp('approved_at')->nullable()->after('status');
      $table->timestamp('rejected_at')->nullable()->after('approved_at');
      $table->foreignId('reviewed_by')->nullable()->after('rejected_at')->constrained('users')->nullOnDelete();
      $table->text('rejection_reason')->nullable()->after('reviewed_by');
      $table->string('membership_type')->nullable()->after('rejection_reason');
      $table->date('membership_starts_at')->nullable()->after('membership_type');
      $table->date('membership_ends_at')->nullable()->after('membership_starts_at');
      $table->softDeletes();
    });
  }

  public function down(): void
  {
    Schema::table('pembayarans', function (Blueprint $table) {
      $table->dropConstrainedForeignId('reviewed_by');
      $table->dropSoftDeletes();
      $table->dropColumn([
        'email',
        'transaction_id',
        'payment_channel',
        'notes',
        'approved_at',
        'rejected_at',
        'rejection_reason',
        'membership_type',
        'membership_starts_at',
        'membership_ends_at',
      ]);
    });
  }
};
