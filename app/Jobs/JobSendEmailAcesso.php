<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Mail\EmailAcesso;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class JobSendEmailAcesso implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private $userId, private $passwordperson)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Recuperar os dados do usuário
        $user = User::find($this->userId);

        // Dados que serão enviados ao construtor da classe EmailAcesso
        $dados = [
            'nome' => $user->nomecompleto,
            'email' => $user->email,
            'senha' => $this->passwordperson,
            'perfil' => ($user->perfil == "adm" ? "Administrador" : ($user->perfil == "con" ? "Consultor" : "Operador"))
        ];

        // Enviar o email de acesso para o usuário daqui a um minuto(now()->addMinute())
        Mail::to($user->email, $user->nome)->later(now()->addMinute(), new EmailAcesso($dados));
    }
}
