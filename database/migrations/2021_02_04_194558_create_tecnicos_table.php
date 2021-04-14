<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTecnicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tecnicos', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->date('birth');
            $table->string('rg');
            $table->string('cpf');
            $table->date('validity_aso')->nullable();
            $table->date('validity_epi')->nullable();
            $table->date('validity_nr10')->nullable();
            $table->date('validity_nr11')->nullable();
            $table->date('validity_nr35')->nullable();
            $table->string('ctps');
            $table->string('cnh');
            $table->string('situation')->nullable();
            $table->string('phone');
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
        Schema::dropIfExists('tecnicos');
    }
}
