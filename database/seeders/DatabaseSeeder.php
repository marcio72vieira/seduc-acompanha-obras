<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(RegionalSeeder::class);
        $this->call(MunicipioSeeder::class);
        $this->call(EscolaSeeder::class);
        $this->call(TipoobraSeeder::class);
        $this->call(ObjetoSeeder::class);
        $this->call(EstatuSeeder::class);
        $this->call(UserSeeder::class);
    }
}
