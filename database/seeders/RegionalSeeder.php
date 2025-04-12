<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Regional;

class RegionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regional = new Regional();
            $regional->nome = "GRANDE ILHA";
            $regional->ativo = true;
            $regional->created_at = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
            $regional->updated_at = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        $regional->save();
    }
}
