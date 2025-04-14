<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Objeto;

class ObjetoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Objeto::create([
            'nome' => 'SALA DE AULA',
            'ativo' => true
        ]);

        Objeto::create([
            'nome' => 'BANHEIRO',
            'ativo' => true
        ]);

        Objeto::create([
            'nome' => 'LABORATÓRIO',
            'ativo' => true
        ]);

        Objeto::create([
            'nome' => 'QUADRA COBERTA',
            'ativo' => true
        ]);

        Objeto::create([
            'nome' => 'QUADRA DESCOBERTA',
            'ativo' => true
        ]);

        Objeto::create([
            'nome' => 'CANTINA',
            'ativo' => true
        ]);

        Objeto::create([
            'nome' => 'AUDITÓRIO',
            'ativo' => true
        ]);

        Objeto::create([
            'nome' => 'FACHADA',
            'ativo' => true
        ]);

        Objeto::create([
            'nome' => 'PARQUE RECREAÇÃO',
            'ativo' => true
        ]);
    }
}
