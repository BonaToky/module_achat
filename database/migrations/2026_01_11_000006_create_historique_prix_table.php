<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historique_prix', function (Blueprint $table) {
            $table->id('id_historique');
            $table->unsignedBigInteger('id_produit');
            $table->decimal('prix_achat', 15, 2);
            $table->decimal('prix_vente', 15, 2);
            $table->timestamp('date_debut')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('date_fin')->nullable();
            $table->foreign('id_produit')->references('id_produit')->on('produit');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historique_prix');
    }
};
