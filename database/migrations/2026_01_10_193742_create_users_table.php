<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_users'); // SERIAL PRIMARY KEY
            $table->string('nom', 50);
            $table->string('prenom', 50);
            $table->string('numero', 50)->unique();
            $table->string('password_hash', 255);
            $table->string('adress', 100)->nullable();
            $table->decimal('solde', 12, 2)->default(0);
            $table->unsignedBigInteger('id_role');
            $table->boolean('actif')->default(true);

            $table->timestamps();

            $table->foreign('id_role')
                  ->references('id_role')
                  ->on('role')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

;

