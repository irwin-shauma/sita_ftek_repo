<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembimbingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembimbing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mhs_id');
            $table->unsignedBigInteger('dosen1_id');
            $table->unsignedBigInteger('dosen2_id');
            $table->timestamps();

            $table->foreign('mhs_id')
                ->references('id')
                ->on('mahasiswa')
                ->onDelete('cascade');

            $table->foreign('dosen1_id')
                ->references('id')
                ->on('dosen')
                ->onDelete('cascade');

            $table->foreign('dosen2_id')
                ->references('id')
                ->on('dosen')
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
        Schema::dropIfExists('pembimbing');
    }
}
