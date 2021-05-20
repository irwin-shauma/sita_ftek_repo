<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviewer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mhs_id');
            $table->unsignedBigInteger('reviewer1_id');
            $table->unsignedBigInteger('reviewer2_id');
            $table->text('jadwal');
            $table->text('jenis_review')->nullable();
            $table->timestamps();

            $table->foreign('mhs_id')
                ->references('id')
                ->on('mahasiswa')
                ->onDelete('cascade');

            $table->foreign('reviewer1_id')
                ->references('id')
                ->on('dosen')
                ->onDelete('cascade');

            $table->foreign('reviewer2_id')
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
        Schema::dropIfExists('reviewer');
    }
}
