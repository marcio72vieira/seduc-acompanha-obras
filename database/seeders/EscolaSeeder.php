<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Escola;

class EscolaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Escola::create([
            'nome' => 'UNIDADE ESCOLAR BANDEIRA TRIBUZI',
            'endereco' => 'Rua da Concórdia',
            'numero' => '100',
            'complemento' => 'Prox. Praça Gonçalves Dias',
            'bairro' => 'Centro',
            'cep' => '65000-000',
            'fone' => '(98) 32451020',
            'regional_id' => 1,
            'municipio_id' => 1,
            'ativo' => true
        ]);
    }
}
