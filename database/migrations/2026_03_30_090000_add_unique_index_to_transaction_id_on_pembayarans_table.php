<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    $usedIds = [];

    DB::table('pembayarans')
      ->select('id', 'transaction_id', 'created_at')
      ->orderBy('id')
      ->get()
      ->each(function ($payment) use (&$usedIds) {
        $txId = (string) ($payment->transaction_id ?? '');

        if ($txId !== '' && !in_array($txId, $usedIds, true)) {
          $usedIds[] = $txId;
          return;
        }

        do {
          $datePrefix = now()->format('Ymd');
          $newId = 'TXN-' . $datePrefix . '-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));
        } while (in_array($newId, $usedIds, true));

        DB::table('pembayarans')
          ->where('id', $payment->id)
          ->update(['transaction_id' => $newId]);

        $usedIds[] = $newId;
      });

    Schema::table('pembayarans', function (Blueprint $table) {
      $table->unique('transaction_id');
    });
  }

  public function down(): void
  {
    Schema::table('pembayarans', function (Blueprint $table) {
      $table->dropUnique(['transaction_id']);
    });
  }
};
