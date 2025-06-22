<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->string('num_inscription')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->string('cne')->unique();
            $table->string('cin')->nullable();
            $table->enum('genre', ['male', 'female'])->nullable();
            $table->date('date_inscription')->nullable();
            $table->date('date_abandon')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('adresse')->nullable();
            $table->enum('statut', ['en_cours', 'quitté', 'lauréat'])->default('en_cours');
            $table->string('statut_responsable')->nullable();
            $table->string('statut_autre')->nullable();
            $table->string('nom_responsable')->nullable();
            $table->string('tel_responsable')->nullable();
            $table->string('nom_pere')->nullable();
            $table->string('nom_mere')->nullable();
            $table->string('tel_pere')->nullable();
            $table->string('tel_mere')->nullable();
            $table->string('profession_pere')->nullable();
            $table->string('profession_mere')->nullable();
            $table->enum('statut_familial', ['ensemble', 'divorcé'])->nullable();
            $table->string('adresse_pere')->nullable();
            $table->string('adresse_mere')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('transport_discount')->nullable();
            $table->boolean('a_transport')->default(false);
            $table->boolean('isreussit')->default(false);
            $table->year('annee_obtention_bac')->nullable();
            $table->string('annee_academique', 11)->nullable();
            $table->unsignedBigInteger('id_classe')->nullable();
            $table->timestamps();

            $table->foreign('id_classe')->references('id')->on('classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eleves');
    }
};