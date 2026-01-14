<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('limite_stock_produit', function (Blueprint $table) {
            $table->id('id_stock');
            $table->unsignedBigInteger('id_produit');
            $table->integer('quantite_max');
            $table->timestamp('date_debut')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('date_fin')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('id_produit')->references('id_produit')->on('produit');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('limite_stock_produit');
    }
};
