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
        Schema::create('produit', function (Blueprint $table) {
            $table->id('id_produit');
            $table->string('nom', 100);
            $table->text('image')->nullable();
            $table->foreignId('id_categorie')
                  ->constrained('categorie', 'id_categorie')
                  ->onDelete('restrict'); // ou cascade selon vos besoins
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produit');
    }
}; 