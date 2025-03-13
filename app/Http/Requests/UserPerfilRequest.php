<?php

namespace App\Http\Requests;
use App\Rules\CpfValidateRule;
use Illuminate\Foundation\Http\FormRequest;

class UserPerfilRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Exibe os parâmetros que vieram na requisicao para serem validados // dd($this); // dd($this->request); // dd(request()->getPassword()); // dd($this->nomecompleto);

        // Recupera o id do usuário que veio na rota (URL)
        $userId = $this->route('user');

        $rules = [
            'nomecompleto'          => 'required',
            'nome'                  => 'required',
            'cpf'                   => ['required', 'unique:users,cpf,'. ($userId ? $userId->id : null), new CpfValidateRule()],
            'cargo'                 => 'required',
            'fone'                  => 'required',
            'email'                 => 'required|email|unique:users,email,' . ($userId ? $userId->id : null),
            //'perfil'                => 'required',    NÃO EXIGIDO NA ALTERAÇÃO DO PERFIL
            //'ativo'                 => 'required',    NÃO EXIGIDO NA ALTERAÇÃO DO PERFIL
        ];

        // Verifica se o campo password(senha) foi alterado. Se foi, aplica as regras necessárias
        if($this->password !=  null)
        {
            $rules += ['password' => 'required|min:6|confirmed'];
            $rules += ['password_confirmation' => 'required'];
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'nomecompleto.required'             => 'O campo Nome Completo é obrigatório!',
            'nome.required'                     => 'O campo Nome é obrigatório!',
            'cpf.required'                      => 'O campo CPF é obrigatório!',
            'cpf.unique'                        => 'Este CPF já está cadastrado!',
            'cargo.required'                    => 'O campo Cargo é obrigatório!',
            'fone.required'                     => 'O campo Telefone é obrigatório!',
            'email.required'                    => 'O campo Email é obrigatório!',
            'email.email'                       => 'O campo Email precisa ser válido!',
            'email.unique'                      => 'Este Email já está cadastrado!',
            //'perfil.required'                   => 'O campo Perfil é obrigatório!', NÃO EXIGIDO NA ALTERAÇÃO DO PERFIL
            //'ativo.required'                    => 'O campo Ativo é obrigatório!', NÃO EXIGIDO NA ALTERAÇÃO DO PERFIL
        ];

        // Verifica se o campo password(senha) foi alterado. Se foi, aplicada as regras, exibe as respectivas mensagens
        if($this->password != null)
        {
            $messages += ['password.required'       => 'O campo Senha é obrigatório!'];
            $messages += ['password.min'            => 'O campo Senha, deve ter pelo menos 6 carcteres!'];
            $messages += ['password.confirmed'      => 'O campo Senha difere da Confirmação de Senha!'];
            $messages += ['password_confirmation.required'      => 'O campo Confirmar Senha é obrigatório!'];
        }

        return $messages;
    }
}
