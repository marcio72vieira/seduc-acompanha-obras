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
            'cor' => '#6d8196',
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
            'cor' => '#0bda51',
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

        Estatu::create([
            'tipo' => 'progressivo',
            'nome' => 'FASE INICIAL',
            'valormin' => 1,
            'valormax' => 33,
            'cor' => '#0d6efc',
            'ativo' => true
        ]);

        Estatu::create([
            'tipo' => 'progressivo',
            'nome' => 'FASE INTERMEDIÁRIA',
            'valormin' => 34,
            'valormax' => 67,
            'cor' => '#ffa500',
            'ativo' => true
        ]);

        Estatu::create([
            'tipo' => 'progressivo',
            'nome' => 'FASE AVANÇADA',
            'valormin' => 68,
            'valormax' => 100,
            'cor' => '#2e6f40',
            'ativo' => true
        ]);
    }
}
