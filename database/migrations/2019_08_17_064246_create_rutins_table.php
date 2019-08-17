<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRutinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rutins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bulan_id');
            $table->date('tanggal');
            $table->integer('perpus');
            $table->integer('kegiatan');
            $table->integer('evaluasi');
            $table->integer('pengelolaan');
            $table->integer('daya');
            $table->integer('honor');
            $table->integer('jumlah');
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
        Schema::dropIfExists('rutins');
    }
}
