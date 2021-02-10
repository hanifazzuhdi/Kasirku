<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->text('barcode')->nullable();
            $table->string('nama_barang');
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->unsignedBigInteger('kategori');
            $table->unsignedBigInteger('merek');
            $table->integer('stok')->default(0);
            $table->integer('diskon')->default(0);
            $table->timestamps();

            // $table->foreign('kategori')->references('id')->on('kategoris');
            // $table->foreign('merek')->references('id')->on('mereks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangs');
    }
}
