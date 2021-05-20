<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_kolokium_lanjut', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mhs_id')->nullable();
            $table->unsignedBigInteger('reviewer_id')->nullable();
            $table->string('reviewer_ke')->nullable();
            $table->string('name')->nullable();
            $table->string('nim')->nullable();
            $table->float('nilai_isi_materi', 3, 2)->nullable();
            $table->float('nilai_presentasi', 3, 2)->nullable();
            $table->float('nilai_penguasaan_materi', 3, 2)->nullable();
            $table->float('total_isi_materi', 3, 2)->nullable();
            $table->float('total_presentasi', 3, 2)->nullable();
            $table->float('total_penguasaan_materi', 3, 2)->nullable();
            $table->float('total_all', 3, 2)->nullable();
            // $table->string('total_aksara')->nullable();
            $table->text('tanggal_penilaian')->nullable();
            $table->timestamps();

            $table->foreign('mhs_id')
                ->references('id')
                ->on('mahasiswa')
                ->onDelete('cascade');
            $table->foreign('reviewer_id')
                ->references('id')
                ->on('dosen')
                ->onDelete('cascade');
        });
        Schema::create('nilai_bimbingan_tugas_akhir', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mhs_id')->nullable();
            $table->unsignedBigInteger('pembimbing_id')->nullable();
            $table->string('name')->nullable();
            $table->string('nim')->nullable();
            $table->string('judul')->nullable();
            $table->float('nilai', 3, 2)->nullable();
            $table->text('komentar')->nullable();
            $table->float('total_all', 3, 2)->nullable();
            // $table->string('total_aksara')->nullable();
            $table->text('tanggal_penilaian')->nullable();
            $table->timestamps();

            $table->foreign('mhs_id')
                ->references('id')
                ->on('mahasiswa')
                ->onDelete('cascade');

            $table->foreign('pembimbing_id')
                ->references('id')
                ->on('dosen')
                ->onDelete('cascade');
        });
        Schema::create('nilai_review_paper', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mhs_id')->nullable();
            $table->unsignedBigInteger('reviewer_id')->nullable();
            $table->string('reviewer_ke')->nullable();
            $table->string('name')->nullable();
            $table->string('nim')->nullable();
            $table->float('nilai_bobot_ta', 3, 2)->nullable();
            $table->float('nilai_novelty', 3, 2)->nullable();
            $table->float('nilai_metodologi', 3, 2)->nullable();
            $table->float('nilai_kelengkapan_analisis', 3, 2)->nullable();
            $table->float('nilai_daftar_pustaka', 3, 2)->nullable();
            $table->float('nilai_kaidah_penulisan', 3, 2)->nullable();
            $table->float('nilai_kesinambungan', 3, 2)->nullable();
            $table->float('nilai_template_ta', 3, 2)->nullable();

            $table->float('total_nilai_bobot_ta', 3, 2)->nullable();
            $table->float('total_nilai_novelty', 3, 2)->nullable();
            $table->float('total_nilai_metodologi', 3, 2)->nullable();
            $table->float('total_nilai_kelengkapan_analisis', 3, 2)->nullable();
            $table->float('total_nilai_daftar_pustaka', 3, 2)->nullable();
            $table->float('total_nilai_kaidah_penulisan', 3, 2)->nullable();
            $table->float('total_nilai_kesinambungan', 3, 2)->nullable();
            $table->float('total_nilai_template_ta', 3, 2)->nullable();
            $table->float('total_all', 3, 2)->nullable();
            // $table->string('total_aksara')->nullable();
            $table->text('tanggal_penilaian')->nullable();
            $table->timestamps();


            $table->foreign('mhs_id')
                ->references('id')
                ->on('mahasiswa')
                ->onDelete('cascade');

            $table->foreign('reviewer_id')
                ->references('id')
                ->on('dosen')
                ->onDelete('cascade');
        });
        Schema::create('rekap_nilai_tugas_akhir', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mhs_id')->nullable();
            $table->string('name')->nullable();
            $table->string('nim')->nullable();
            $table->float('nilai_pembimbing', 3, 2)->nullable();
            $table->float('nilai_reviewer1_paper', 3, 2)->nullable();
            $table->float('nilai_reviewer2_paper', 3, 2)->nullable();
            $table->float('nilai_kolokium_lanjut', 3, 2)->nullable();
            $table->float('total_nilai_akhir', 3, 2)->nullable();
            $table->string('total_aksara')->nullable();
            $table->text('tanggal_penilaian')->nullable();
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
        Schema::dropIfExists('nilai_kolokium_lanjut');
        Schema::dropIfExists('nilai_bimbingan_tugas_akhir');
        Schema::dropIfExists('nilai_review_paper');
        Schema::dropIfExists('rekap_nilai_tugas_akhir');
    }
}
