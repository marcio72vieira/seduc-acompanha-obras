<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ObraRequest extends FormRequest
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
        $rules = [
            'tipoobra_id'       => 'bail|required',
            'municipio_id'      => 'bail|required',
            'escola_id'         => 'bail|required',
            'data_inicio'       => 'bail|required',
            'data_fim'          => 'bail|required|afterOrEqual:data_inicio',
            'ativo'             => 'bail|required',
            'descricao'         => 'bail|required',
        ];

        // Se nenhum "objeto de construção/reforma" for escolhido a variável/array "objetos" irá vir vazia (null).
        // Como sabemos, "checkbox" quando não é checkado a variável que o representa não é enviado para
        // processamento, ou seja, ele é null (não existe), diferentemente de um "radio button" que possui
        // sempre dois valores do tipo: "sim" ou "não".
        if($this->objetos == null){
            $rules += ['objetos' => 'required'];
        }

        if($this->users == null){
            $rules += ['users' => 'required'];
        }

        return $rules;

    }

    public function messages(): array
    {
        return[
            'tipoobra_id.required' => 'Campo tipo de obra é obrigatório',
            'municipio_id.required' => 'Escolha um município',
            'escola_id.required' => 'Selecione uma escola',
            'data_inicio.required' => 'Campo data inicial é obrigatório!',
            'data_fim.required' => 'Campo data final é obrigatório!',
            'data_fim.afterOrEqual' => 'Data não pode ser inferior a data inicial!',
            'ativo.required' => 'Campo ativo é obrigatório!',
            'descricao.required' => 'Campo descrição é obrigatório!',
            'objetos.required' => 'Escolha pelo menos um objeto!',
            'users.required' => 'Escolha pelo menos um responsável!'
        ];
    }
}
