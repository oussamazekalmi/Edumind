<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNiveauxTable extends Migration
{
    public function up()
    {
        Schema::create('niveaux', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cycle');
            $table->string('nom');
            $table->decimal('montant_scolarite', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('id_cycle')->references('id')->on('cycles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('niveaux');
    }
}