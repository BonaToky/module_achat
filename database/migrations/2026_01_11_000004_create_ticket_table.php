<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket', function (Blueprint $table) {
            $table->id('id_ticket');
            $table->enum('mode_paiement', ['cash', 'mobile_money', 'carte']);
            $table->decimal('total', 15, 2);
            $table->timestamp('date_vente');
            $table->unsignedBigInteger('id_client');
            $table->foreign('id_client')->references('id_users')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket');
    }
};
