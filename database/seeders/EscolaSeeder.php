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

        Escola::create([
            'nome' => 'UNIDADE ESCOLAR ESTADO DO PARÁ',
            'endereco' => 'Rua Raimundo Corrêa',
            'numero' => '150',
            'complemento' => 'Prox. Ladeira da Floresta',
            'bairro' => 'Liberdade',
            'cep' => '65050-000',
            'fone' => '(98) 324510002',
            'regional_id' => 1,
            'municipio_id' => 1,
            'ativo' => true
        ]);

        Escola::create([
            'nome' => 'LICEU MARANHENSE SJR',
            'endereco' => 'Av. Casemiro Júnior',
            'numero' => 's/n',
            'complemento' => 'Próximo Entrda de Panaquatira',
            'bairro' => 'Maruinho',
            'cep' => '65110-000',
            'fone' => '(98) 32252040',
            'regional_id' => 1,
            'municipio_id' => 2,
            'ativo' => true
        ]);

        Escola::create([
            'nome' => 'COLÉGIO ELEOTÉRIO DOS REIS',
            'endereco' => 'Av. Dom Pedro II',
            'numero' => '10',
            'complemento' => 'Praça da Matriz',
            'bairro' => 'CENTRO',
            'cep' => '65110-000',
            'fone' => '(98) 32252040',
            'regional_id' => 2,
            'municipio_id' => 5,
            'ativo' => true
        ]);

        Escola::create([
            'nome' => 'CENTRO DE ENSINO MÉDIO IPIRANGA',
            'endereco' => 'Rua da Paz',
            'numero' => '100',
            'complemento' => 'Próximo a BR 135',
            'bairro' => 'CENTRO SÃO JOÃO BATISTA',
            'cep' => '652200-000',
            'fone' => '(98) 32452222',
            'regional_id' => 2,
            'municipio_id' => 6,
            'ativo' => true
        ]);
    }
}
