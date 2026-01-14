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
        Schema::create('mouvement_stock', function (Blueprint $table) {
            $table->id('id_mouvement_stock');
            $table->string('type_mouvement_stock', 50);
            $table->integer('quantite');
            $table->timestamp('date_mouv')->useCurrent();
            $table->foreignId('id_categorie')->constrained('categorie', 'id_categorie');
            $table->foreignId('id_produit')->constrained('produit', 'id_produit');
            
            $table->timestamps(); // Optionnel - ajoute created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mouvement_stock');
    }
};