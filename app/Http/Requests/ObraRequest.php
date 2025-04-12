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
        /* return [
            'descricao'         => 'bail|required',
            'escola_id'         => 'bail|required',
            'data_inicio'       => 'bail|required',
            'data_fim'          => 'bail|required',
            'ativo'             => 'bail|required',
        ]; */


        $rules = [
            'descricao'         => 'bail|required',
            'escola_id'         => 'bail|required',
            'data_inicio'       => 'bail|required',
            'data_fim'          => 'bail|required',
            'ativo'             => 'bail|required',
        ];

        // Se nenhum "objeto de construção/reforma" for escolhido a variável/array "objetos" virá vazia (null).
        // Como sabemos, "checkbox" quando não é checkado a variável que o represdnta não é enviado para
        // processamento, ou seja, ele é null (não existe), diferentemente de um "radio button" que possui 
        // sempre dois valores do tipo: "sim" ou "não".
        if($this->objetos == null){
            $rules += ['objetos' => 'required'];
        }

        return $rules;

    }

    public function messages(): array
    {
        return[
            'descricao.required' => 'Campo descrição é obrigatório!',
            'escola_id.required' => 'Selecione uma escola',
            'data_inicio.required' => 'Campo data inicial é obrigatório!',
            'data_fim.required' => 'Campo data final é obrigatório!',
            'ativo.required' => 'Campo ativo é obrigatório!',
            'objetos.required' => 'Escolha pelo menos um objeto!'
        ];
    }
}
