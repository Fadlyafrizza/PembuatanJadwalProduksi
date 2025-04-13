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
        Schema::create('tbahan_baku', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bahan');
            $table->integer('stok');
        });

        Schema::create('tmesin', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('tipe');
            $table->integer('kapasitas');
            $table->enum('status', ['aktif', 'nonaktif', 'perawatan']);
        });

        Schema::create('tproduk', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->decimal('harga', 10, 2);
            $table->text('deskripsi');
            $table->integer('waktu_produk');
            $table->timestamps();
        });

        Schema::create('tproduk_bahan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produk_id');
            $table->unsignedBigInteger('bahan_id');
            $table->integer('jumlah');
            $table->foreign('produk_id')->references('id')->on('tproduk')->onDelete('cascade');
            $table->foreign('bahan_id')->references('id')->on('tbahan_baku')->onDelete('cascade');
        });

        Schema::create('torder', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produk_id');
            $table->integer('jumlah');
            $table->decimal('total_harga', 10, 2);
            $table->dateTime('tanggal_pesan');
            $table->enum('status', ['pending', 'scheduled', 'completed']);
            $table->foreign('produk_id')->references('id')->on('tproduk')->onDelete('cascade');
        });

        Schema::create('tjadwal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('mesin_id')->nullable();
            $table->dateTime('waktu_mulai')->nullable();
            $table->dateTime('waktu_selesai')->nullable();
            $table->enum('status', ['scheduled', 'in_progress', 'completed']);
            $table->foreign('order_id')->references('id')->on('torder')->onDelete('cascade');
            $table->foreign('mesin_id')->references('id')->on('tmesin')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tjadwal');
        Schema::dropIfExists('tproduk_bahan');
        Schema::dropIfExists('torder');
        Schema::dropIfExists('tproduk');
        Schema::dropIfExists('tmesin');
        Schema::dropIfExists('tbahan_baku');
    }
};
