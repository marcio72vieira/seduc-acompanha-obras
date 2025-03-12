<?php

namespace App\Http\Requests;
use App\Rules\CpfValidateRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $userId = $this->route('user');

        $rules = [
            'nomecompleto'          => 'required',
            'nome'                  => 'required',
            'cpf'                   => ['required', 'unique:users,cpf,'. ($userId ? $userId->id : null), new CpfValidateRule()],
            'cargo'                 => 'required',
            'fone'                  => 'required',
            'perfil'                => 'required',
            'email'                 => 'required|email|unique:users,email,' . ($userId ? $userId->id : null),
            'ativo'                 => 'required',
        ];

        // Verifica se o método atual de submissão é POST, significando que se está CADASTRANDO um Usuário. Nesse caso é exigido que o Administrador informe a senha com  a
        // adição dos elemntos a serem validados, no array $rules[]. Caso contrŕio, se o método atual de submissão for "PUT", significa que se está editando. Neste caso, O
        // administrador não tem a obrigação de informar a senha. Este recurso foi adpatado do site de referência abaixo:
        // https://laracasts.com/discuss/channels/general-discussion/l5-validate-request-rules-for-both-create-and-update?utm_source=pocket_saves
        // dd($this) Mostra todos as propriedades do objeto atual. Obs: Acrescenta-se (+=) como forma de adicinar elementos a um array associativos no php, de outra forma seria
        // apenas array_tal[] = "valor"

        if($this->method() == 'POST')
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
            'perfil.required'                   => 'O campo Perfil é obrigatório!',
            'email.required'                    => 'O campo Email é obrigatório!',
            'email.email'                       => 'O campo Email precisa ser válido!',
            'email.unique'                      => 'Este Email já está cadastrado!',
            'ativo.required'                    => 'O campo Ativo é obrigatório!',
        ];

        if($this->method() == 'POST')
        {
            $messages += ['password.required'       => 'O campo Senha é obrigatório!'];
            $messages += ['password.min'            => 'O campo Senha, deve ter pelo menos 6 carcteres!'];
            $messages += ['password.confirmed'      => 'O campo Senha difere da Confirmação de Senha!'];
        }

        return $messages;
    }
}
