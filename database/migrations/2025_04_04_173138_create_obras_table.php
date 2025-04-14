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
        Schema::create('obras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipoobra_id')->constrained('tipoobras')->onDelete('cascade');
            $table->foreignId('escola_id')->constrained('escolas')->onDelete('cascade');
            $table->foreignId('regional_id')->constrained('regionais')->onDelete('cascade');
            $table->foreignId('municipio_id')->constrained('municipios')->onDelete('cascade');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->boolean('estatus');     // MySQL cria uma coluna do tipo tinyint(1)
            $table->boolean('ativo');
            $table->string('descricao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obras');
    }
};
