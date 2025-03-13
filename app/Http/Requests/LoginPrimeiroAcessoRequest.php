<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class LoginPrimeiroAcessoRequest extends FormRequest
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
        return [
            'email'                 => 'required|email',
            'passwordatual'         => 'required',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function messages(): array
    {
        return[
            'email.required'            => 'Informe o E-mail cadastrado',
            'email.email'               => 'Informe um E-mail válido',
            'passwordatual.required'    => 'Informe a Senha atual',
            'password.required'         => 'Informe a Nova senha',
            'password.min'              => 'Informe pelo menos 6 caracteres na Nova Senha!',
            'password.confirmed'        => 'Os campos Nova Senha e Confirmar Senha, não coincidem!',
            'password_confirmation.required' => 'O campo Confirmar Senha é obrigatório!',
        ];
    }
}
