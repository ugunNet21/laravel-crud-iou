<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('bsre_data', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->nullable();
            $table->string('passphrase')->nullable();
            $table->string('tampilan')->nullable();
            $table->integer('page')->nullable();
            $table->boolean('image')->nullable();
            $table->string('linkQR')->nullable();
            $table->integer('xAxis')->nullable();
            $table->integer('yAxis')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('file')->nullable();
            $table->string('tag_koordinat')->nullable();
            $table->string('id_dokumen')->nullable();
            $table->string('file_keterangan_dtks_sudtks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bsre_data');
    }
};
