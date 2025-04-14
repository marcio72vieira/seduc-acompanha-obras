<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tipoobra;

class TipoobraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tipoobra::create([
            'nome' => 'CONSTRUÇÃO',
            'ativo' => true
        ]);

        Tipoobra::create([
            'nome' => 'REFORMA',
            'ativo' => true
        ]);

        Tipoobra::create([
            'nome' => 'REVITALIZAÇÃO',
            'ativo' => true
        ]);

        Tipoobra::create([
            'nome' => 'CONSTRUÇÃO E REFORMA',
            'ativo' => true
        ]);

        Tipoobra::create([
            'nome' => 'CONSTRUÇÃO E REVITALIZAÇÃO',
            'ativo' => true
        ]);

        Tipoobra::create([
            'nome' => 'REFORMA E REVITALIZAÇÃO',
            'ativo' => true
        ]);
    }
}
