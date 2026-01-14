<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('details_vente', function (Blueprint $table) {
            $table->id('id_details_vente');
            $table->unsignedBigInteger('id_produit');
            $table->unsignedBigInteger('id_ticket');
            $table->integer('quantite');
            $table->decimal('prix_unitaire', 15, 2);
            $table->decimal('total_ligne', 15, 2);
            $table->foreign('id_produit')->references('id_produit')->on('produit');
            $table->foreign('id_ticket')->references('id_ticket')->on('ticket');
            $table->integer('qte')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('details_vente');
    }
};
