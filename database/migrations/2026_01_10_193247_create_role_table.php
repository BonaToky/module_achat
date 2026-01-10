<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role', function (Blueprint $table) {
            $table->id('id_role');         // équivalent SERIAL
            $table->string('libelle', 50); // VARCHAR(50) NOT NULL
            $table->timestamps();          // created_at + updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role');
    }
};
