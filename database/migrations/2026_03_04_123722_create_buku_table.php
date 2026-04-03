<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id(); 
            $table->string('judul_buku');
            $table->string('pengarang');
            $table->string('penerbit');
            $table->year('tahun_terbit');
            $table->string('kategori');
            $table->integer('stok');
            
            // Tambahkan kolom ini untuk menyimpan path/nama file gambar cover
            $table->string('cover')->nullable(); 

            // Relasi: Admin (User) mengelola Buku
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Pastikan nama tabel di sini 'bukus' agar sesuai dengan up()
        Schema::dropIfExists('bukus');
    }
};