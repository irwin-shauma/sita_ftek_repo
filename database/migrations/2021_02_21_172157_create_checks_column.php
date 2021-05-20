<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecksColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kolokium_awal', function (Blueprint $table) {
            $table->boolean('check_kartu_studi_tetap')->nullable()->after('lembar_reviewer');
            $table->boolean('check_transkrip_nilai')->nullable()->after('check_kartu_studi_tetap');
            $table->boolean('check_form_pengajuan_ta')->nullable()->after('check_transkrip_nilai');
            $table->boolean('check_tagihan_pembayaran')->nullable()->after('check_form_pengajuan_ta');
            $table->boolean('check_proposal_awal')->nullable()->after('check_tagihan_pembayaran');
            $table->boolean('check_lembar_reviewer')->nullable()->after('check_proposal_awal');
            $table->integer('check_korkon')->nullable()->after('check_lembar_reviewer');
            $table->integer('check_mhs_send')->nullable()->after('check_korkon');
        });
        Schema::table('kolokium_lanjut', function (Blueprint $table) {
            $table->boolean('check_proposal_lanjut')->nullable()->after('surat_tugas');
            $table->boolean('check_surat_tugas')->nullable()->after('check_proposal_lanjut');
            $table->integer('check_korkon')->nullable()->after('check_surat_tugas');
            $table->integer('check_mhs_send')->nullable()->after('check_korkon');
        });
        Schema::table('pengajuan_review', function (Blueprint $table) {
            $table->boolean('check_makalah')->nullable()->after('cek_plagiasi');
            $table->boolean('check_surat_tugas')->nullable()->after('check_makalah');
            $table->boolean('check_scan_ijazah')->nullable()->after('check_surat_tugas');
            $table->boolean('check_transkrip_nilai')->nullable()->after('check_scan_ijazah');
            $table->boolean('check_tagihan_pembayaran')->nullable()->after('check_transkrip_nilai');
            $table->boolean('check_transkrip_poin')->nullable()->after('check_tagihan_pembayaran');
            $table->boolean('check_kartu_studi')->nullable()->after('check_transkrip_poin');
            $table->boolean('check_cek_plagiasi')->nullable()->after('check_kartu_studi');
            $table->integer('check_admin')->nullable()->after('check_cek_plagiasi');
            $table->integer('check_mhs_send')->nullable()->after('check_admin');
            $table->integer('check_panitia_ujian')->nullable()->after('check_mhs_send');
            $table->text('date_panitia_ujian')->nullable()->after('check_panitia_ujian');
        });
        Schema::table('pengajuan_publikasi', function (Blueprint $table) {
            $table->boolean('check_makalah')->nullable()->after('cek_plagiasi');
            $table->boolean('check_letter_of_acceptance')->nullable()->after('check_makalah');
            $table->boolean('check_scan_ijazah')->nullable()->after('check_letter_of_acceptance');
            $table->boolean('check_transkrip_nilai')->nullable()->after('check_scan_ijazah');
            $table->boolean('check_tagihan_pembayaran')->nullable()->after('check_transkrip_nilai');
            $table->boolean('check_transkrip_poin')->nullable()->after('check_tagihan_pembayaran');
            $table->boolean('check_kartu_studi')->nullable()->after('check_transkrip_poin');
            $table->boolean('check_cek_plagiasi')->nullable()->after('check_kartu_studi');
            $table->integer('check_admin')->nullable()->after('check_cek_plagiasi');
            $table->integer('check_mhs_send')->nullable()->after('check_admin');
            $table->integer('check_panitia_ujian')->nullable()->after('check_mhs_send');
            $table->text('date_panitia_ujian')->nullable()->after('check_panitia_ujian');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('checks_column');
        Schema::table('kolokium_awal', function (Blueprint $table) {
            $table->dropColumn('check_kartu_studi_tetap');
            $table->dropColumn('check_transkrip_nilai');
            $table->dropColumn('check_form_pengajuan_ta');
            $table->dropColumn('check_tagihan_pembayaran');
            $table->dropColumn('check_proposal_awal');
            $table->dropColumn('check_lembar_reviewer');
        });
        Schema::table('kolokium_lanjut', function (Blueprint $table) {
            $table->dropColumn('check_proposal_lanjut');
            $table->dropColumn('check_surat_tugas');
        });
        Schema::table('pengajuan_review', function (Blueprint $table) {
            $table->dropColumn('check_makalah');
            $table->dropColumn('check_surat_tugas');
            $table->dropColumn('check_scan_ijazah');
            $table->dropColumn('check_transkrip_nilai');
            $table->dropColumn('check_tagihan_pembayaran');
            $table->dropColumn('check_transkrip_poin');
            $table->dropColumn('check_kartu_studi');
            $table->dropColumn('check_cek_plagiasi');
        });
        Schema::table('pengajuan_publikasi', function (Blueprint $table) {
            $table->dropColumn('check_makalah');
            $table->dropColumn('check_letter_of_acceptance');
            $table->dropColumn('check_scan_ijazah');
            $table->dropColumn('check_transkrip_nilai');
            $table->dropColumn('check_tagihan_pembayaran');
            $table->dropColumn('check_transkrip_poin');
            $table->dropColumn('check_kartu_studi');
            $table->dropColumn('check_cek_plagiasi');
        });
    }
}
