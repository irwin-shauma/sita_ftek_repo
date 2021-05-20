<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipeKorkonColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kolokium_lanjut', function (Blueprint $table) {
            $table->string('tipe_korkon')->nullable()->after('mhs_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kolokium_lanjut', function (Blueprint $table) {
            $table->dropColumn('tipe_korkon');
        });
    }
}
