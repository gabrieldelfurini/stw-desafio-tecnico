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
        Schema::create('ingrediente_receita', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('receita_id');
            $table->unsignedBigInteger('ingrediente_id');

            $table->integer('ordem');
            $table->float('quantidade_prevista');

            $table->foreign('receita_id')->references('id')->on('receitas')->onDelete('cascade');
            $table->foreign('ingrediente_id')->references('id')->on('ingredientes')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingrediente_receita');
    }
};
