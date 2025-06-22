<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFraisTable extends Migration
{
    public function up()
    {
        Schema::create('frais', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['inscription', 'scolaire', 'transport']);
            $table->decimal('montant', 10, 2);
            $table->string('mode_paiement')->nullable();
            $table->date('date_paiement');
            $table->string('frequence_paiement')->nullable();
            $table->date('interval_debut')->nullable();
            $table->date('interval_fin')->nullable();
            $table->enum('statut', ['payé', 'partiel', 'non payé']);
            $table->year('année');
            $table->unsignedBigInteger('id_eleve');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_eleve')->references('id')->on('eleves')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('frais');
    }
}
