<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inserts', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('tanggal_lahir');
            $table->bigInteger('no_bpjs');
            $table->string('status_bpjs');
            $table->bigInteger('no_ktp')->nullable();           
            $table->string('nama_provider')->nullable();        
            $table->string('no_rekam_medis');          
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
        Schema::dropIfExists('inserts');
    }
};
