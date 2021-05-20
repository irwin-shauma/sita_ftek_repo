<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name')->nullable();
            $table->string('nim')->unique()->nullable();
            $table->integer('progress')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // $table->primary(['user_id'], 'mahasiswa_user_id_primary');
        });

        Schema::create('kolokium_awal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mhs_id');
            $table->string('tipe_korkon')->nullable();
            $table->string('kartu_studi_tetap')->nullable();
            $table->string('transkrip_nilai')->nullable();
            $table->string('form_pengajuan_ta')->nullable();
            $table->string('tagihan_pembayaran')->nullable();
            $table->string('proposal_awal')->nullable();
            $table->string('lembar_reviewer')->nullable();
            $table->timestamps();

            $table->foreign('mhs_id')
                ->references('id')
                ->on('mahasiswa')
                ->onDelete('cascade');
        });

        Schema::create('kolokium_lanjut', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mhs_id');
            $table->string('proposal_lanjut')->nullable();
            $table->string('surat_tugas')->nullable();
            $table->timestamps();

            $table->foreign('mhs_id')
                ->references('id')
                ->on('mahasiswa')
                ->onDelete('cascade');
        });

        Schema::create('pengajuan_review', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mhs_id');
            $table->string('makalah')->nullable();
            $table->string('surat_tugas')->nullable();
            $table->string('scan_ijazah')->nullable();
            $table->string('transkrip_nilai')->nullable();
            $table->string('tagihan_pembayaran')->nullable();
            $table->string('transkrip_poin')->nullable();
            $table->string('kartu_studi')->nullable();
            $table->string('cek_plagiasi')->nullable();
            $table->timestamps();

            $table->foreign('mhs_id')
                ->references('id')
                ->on('mahasiswa')
                ->onDelete('cascade');
        });

        Schema::create('pengajuan_publikasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mhs_id')->nullable();
            $table->string('makalah')->nullable();
            $table->string('letter_of_acceptance')->nullable();
            $table->string('scan_ijazah')->nullable();
            $table->string('transkrip_nilai')->nullable();
            $table->string('tagihan_pembayaran')->nullable();
            $table->string('transkrip_poin')->nullable();
            $table->string('kartu_studi')->nullable();
            $table->string('cek_plagiasi')->nullable();
            $table->timestamps();

            $table->foreign('mhs_id')
                ->references('id')
                ->on('mahasiswa')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa');
        Schema::dropIfExists('kolokium_awal');
        Schema::dropIfExists('pengajuan_review');
        Schema::dropIfExists('pengajuan_publikasi');
    }
}
