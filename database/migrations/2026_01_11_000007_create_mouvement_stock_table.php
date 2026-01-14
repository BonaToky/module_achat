<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mouvement_stock', function (Blueprint $table) {
            $table->id('id_mouvement_stock');
            $table->enum('type_mouvement_stock', ['entree', 'sortie']);
            $table->integer('quantite');
            $table->timestamp('date_mouv')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedBigInteger('id_categorie');
            $table->unsignedBigInteger('id_produit');
            $table->foreign('id_categorie')->references('id_categorie')->on('categorie');
            $table->foreign('id_produit')->references('id_produit')->on('produit');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mouvement_stock');
    }
};
