<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livraison', function (Blueprint $table) {
            $table->id('id_livraison');
            $table->unsignedBigInteger('id_ticket');
            $table->string('adresse_livraison', 255);
            $table->string('statut_livraison', 50)->default('en_attente');
            $table->date('date_livraison_prevue')->nullable();
            $table->timestamp('date_livraison_reelle')->nullable();
            $table->unsignedBigInteger('livreur_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->foreign('id_ticket')->references('id_ticket')->on('ticket')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('livreur_id')->references('id_users')->on('users')->onUpdate('cascade')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livraison');
    }
};
