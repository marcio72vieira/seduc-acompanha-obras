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
        Schema::create('atividades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('obra_id')->constrained('obras')->onDelete('cascade');
            $table->date('data_registro');
            $table->text('registro');
            $table->tinyInteger('progresso');   // valores em percentagem 1% a 100%
            $table->text('observacao');         // Campo acessado exclusivamente pelo consultor
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atividades');
    }
};
