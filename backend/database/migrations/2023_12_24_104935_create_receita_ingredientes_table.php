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
        Schema::create('receita_ingredientes', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('receita_id')->constrained();
            $table->foreignId('ingrediente_id')->constrained();

            $table->integer('ordem');
            $table->float('quantidade_prevista');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receita_ingredientes');
    }
};
