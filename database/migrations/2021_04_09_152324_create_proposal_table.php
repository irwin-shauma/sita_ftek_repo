<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal_awal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mhs_id');
            $table->integer('nomor_revisi')->nullable();
            $table->string('file_proposal')->nullable();
            $table->text('komentar')->nullable();
            $table->string('sender')->nullable();
            $table->boolean('check1')->nullable();
            $table->boolean('check2')->nullable();
            $table->boolean('acc1')->nullable();
            $table->boolean('acc2')->nullable();
            $table->boolean('review_check1')->nullable();
            $table->boolean('review_check2')->nullable();
            $table->boolean('review_acc1')->nullable();
            $table->boolean('review_acc2')->nullable();
            $table->integer('check_validasi_korkon')->nullable();
            $table->integer('check_mhs_send')->nullable();


            $table->timestamps();

            $table->foreign('mhs_id')
                ->references('id')
                ->on('mahasiswa')
                ->onDelete('cascade');
        });
        Schema::create('proposal_lanjut', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mhs_id');
            $table->integer('nomor_revisi')->nullable();
            $table->string('file_proposal')->nullable();
            $table->text('komentar')->nullable();
            $table->string('sender')->nullable();
            $table->boolean('check1')->nullable();
            $table->boolean('check2')->nullable();
            $table->boolean('acc1')->nullable();
            $table->boolean('acc2')->nullable();
            $table->boolean('review_check1')->nullable();
            $table->boolean('review_check2')->nullable();
            $table->boolean('review_acc1')->nullable();
            $table->boolean('review_acc2')->nullable();
            $table->integer('check_validasi_korkon')->nullable();
            $table->integer('check_mhs_send')->nullable();

            $table->timestamps();

            $table->foreign('mhs_id')
                ->references('id')
                ->on('mahasiswa')
                ->onDelete('cascade');
        });
        Schema::create('paper_review', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mhs_id');
            $table->integer('nomor_revisi')->nullable();
            $table->string('file_paper')->nullable();
            $table->text('komentar')->nullable();
            $table->string('sender')->nullable();
            $table->boolean('check1')->nullable();
            $table->boolean('check2')->nullable();
            $table->boolean('acc1')->nullable();
            $table->boolean('acc2')->nullable();
            $table->boolean('review_check1')->nullable();
            $table->boolean('review_check2')->nullable();
            $table->boolean('review_acc1')->nullable();
            $table->boolean('review_acc2')->nullable();
            $table->integer('check_validasi_panitia_ujian')->nullable();
            $table->integer('check_mhs_send')->nullable();

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
        Schema::dropIfExists('proposal_awal');
        Schema::dropIfExists('proposal_lanjut');
        Schema::dropIfExists('paper_review');
    }
}
