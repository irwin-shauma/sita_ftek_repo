<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNomorSurat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nomor_surat', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('nim')->nullable();
            $table->string('nomor')->nullable();
            $table->string('judul')->nullable();
            // $table->text('tanggal_kop')->nullable();
            $table->text('tanggal_awal')->nullable();
            $table->text('tanggal_akhir')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nomor_surat');
    }
}
