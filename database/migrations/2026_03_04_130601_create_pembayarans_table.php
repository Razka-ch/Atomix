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
    Schema::create('pembayarans', function (Blueprint $table) {
        $table->id(); // id_pembayaran
        
        // Relasi ke User (Sesuai atribut id_user & id_member di ERD)
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        
        // Relasi ke Buku (Sesuai panah ERD Buku -> Melakukan -> Pembayaran)
        // Nullable karena pembayaran bisa jadi hanya untuk daftar membership, bukan beli buku
        $table->foreignId('buku_id')->nullable()->constrained('bukus')->nullOnDelete();
        
        $table->string('bukti_pembayaran');
        $table->decimal('nominal', 15, 2);
        $table->enum('status', ['pending', 'lunas', 'gagal'])->default('pending');
        $table->string('no_whatsapp');
        $table->dateTime('tgl_beli'); // Sesuai atribut tgl_beli
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
