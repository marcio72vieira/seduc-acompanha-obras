<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estatu;

class EstatuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estatu::create([
            'tipo' => 'informativo',
            'nome' => 'CRIADA',
            'valormin' => null,
            'valormax' => null,
            'cor' => '#000000',
            'ativo' => true
        ]);

        Estatu::create([
            'tipo' => 'informativo',
            'nome' => 'PARADA',
            'valormin' => null,
            'valormax' => null,
            'cor' => '#ef2929',
            'ativo' => true
        ]);

        Estatu::create([
            'tipo' => 'informativo',
            'nome' => 'CONCLUÍDA',
            'valormin' => null,
            'valormax' => null,
            'cor' => '#08b317',
            'ativo' => true
        ]);

        Estatu::create([
            'tipo' => 'informativo',
            'nome' => 'INAUGURADA',
            'valormin' => null,
            'valormax' => null,
            'cor' => '#bf40b1',
            'ativo' => true
        ]);

        // fase inicial: #0d6efc; fase intermediária: #fcaf3e; fase avançda: 4e9a06
    }
}
