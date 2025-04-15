<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Municipio;


class MunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $municipio = new Municipio();
            $municipio->nome = "SÃO LUIS";
            $municipio->ativo = true;
            $municipio->regional_id = 1;
        $municipio->save();

        $municipio = new Municipio();
            $municipio->nome = "SÃO JOSÉ DE RIBAMAR";
            $municipio->ativo = true;
            $municipio->regional_id = 1;
        $municipio->save();

        $municipio = new Municipio();
            $municipio->nome = "PAÇO DO LUMIAR";
            $municipio->ativo = true;
            $municipio->regional_id = 1;
        $municipio->save();

        $municipio = new Municipio();
            $municipio->nome = "RAPOSA";
            $municipio->ativo = true;
            $municipio->regional_id = 1;
        $municipio->save();

        $municipio = new Municipio();
            $municipio->nome = "VITÓRIA DO MEARIM";
            $municipio->ativo = true;
            $municipio->regional_id = 2;
        $municipio->save();

        $municipio = new Municipio();
            $municipio->nome = "SÃO JOÃO BATISTA";
            $municipio->ativo = true;
            $municipio->regional_id = 2;
        $municipio->save();

        $municipio = new Municipio();
            $municipio->nome = "ARARI";
            $municipio->ativo = true;
            $municipio->regional_id = 2;
        $municipio->save();

    }
}
