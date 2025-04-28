<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('magang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perusahaan_id')->references('id')->on('perusahaan')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('lokasi');
            $table->string('bidang');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('kuota')->default(1);
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magang');
    }
};
