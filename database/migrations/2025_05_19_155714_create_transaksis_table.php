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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('id_data_pembayaran')->constrained('data_pembayaran')->onDelete('cascade');
            $table->date('tgl_transaksi');
            $table->integer('total_pembayaran');
            $table->string('bukti_bayar');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
