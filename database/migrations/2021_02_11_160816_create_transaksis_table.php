<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->integer('harga_total');
            $table->integer('dibayar');
            $table->integer('kembalian');
            $table->string('kode_member')->nullable()->default('pembeli');
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('kasir_id');
            $table->timestamps();

            $table->foreign('kasir_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
}
