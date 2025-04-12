<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    // Campos nullable não é necessário ser informado
    public function run()
    {
        $user = new User();
            $user->nomecompleto = "Marcio Nonato F Vieira";
            $user->nome = "Marcio Vieira";
            $user->cpf = "471.183.423-00";
            $user->cargo = "Analista de Sistema";
            $user->fone = "(98) 98702-3329";
            $user->perfil = "adm";
            $user->email = "marcio@email.com.br";
            $user->password = Hash::make('123456');
            $user->ativo = true;
            $user->primeiroacesso = 0;
        $user->save();
    }
}
