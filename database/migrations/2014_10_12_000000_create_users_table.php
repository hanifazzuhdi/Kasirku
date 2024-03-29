<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable()->default(now());
            $table->string('is_verified')->default('1');
            $table->string('password');
            $table->integer('umur')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('alamat')->nullable();
            $table->string('avatar')->nullable()->default('https://i.ibb.co/Smw9VXW/Pngtree-users-vector-3725294.png');
            $table->unsignedBigInteger('role_id')->nullable();
            $table->text('remember_token')->nullable();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
