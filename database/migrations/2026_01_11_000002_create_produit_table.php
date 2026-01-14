<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produit', function (Blueprint $table) {
            $table->id('id_produit');
            $table->string('nom', 100);
            $table->text('image')->nullable();
            $table->unsignedBigInteger('id_categorie');
            $table->timestamps();
            $table->foreign('id_categorie')->references('id_categorie')->on('categorie');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produit');
    }
};
